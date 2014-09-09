<?php

namespace Tests\DataValues\Deserializers;

use DataValues\Deserializers\DataValueDeserializer;
use DataValues\NumberValue;
use DataValues\StringValue;

/**
 * @covers DataValues\Deserializers\DataValueDeserializer
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DataValueDeserializerTest extends \PHPUnit_Framework_TestCase {

	public function testGivenEmptyArray_isDeserializerForReturnsFalse() {
		$deserializer = $this->newDeserializer();
		$this->assertFalse( $deserializer->isDeserializerFor( array() ) );
	}

	private function newDeserializer() {
		return new DataValueDeserializer( array(
			'number' => 'DataValues\NumberValue',
			'string' => 'DataValues\StringValue',
		) );
	}

	/**
	 * @dataProvider notAnArrayProvider
	 */
	public function testGivenNonArray_isDeserializerForReturnsFalse( $notAnArray ) {
		$deserializer = $this->newDeserializer();
		$this->assertFalse( $deserializer->isDeserializerFor( $notAnArray ) );
	}

	public function notAnArrayProvider() {
		return array(
			array( null ),
			array( 0 ),
			array( true ),
			array( (object)array() ),
			array( 'foo' ),
		);
	}

	/**
	 * @dataProvider notADataValuesListProvider
	 */
	public function testGivenNonDataValues_constructorThrowsException( array $invalidDVList ) {
		$this->setExpectedException( 'InvalidArgumentException' );

		new DataValueDeserializer( $invalidDVList );
	}

	public function notADataValuesListProvider() {
		return array(
			array(
				array(
					'foo',
					null,
					array(),
					true,
					42,
				)
			),
			array(
				array(
					'string' => 'foo',
				)
			),
			array(
				array(
					'string' => 'DataValues\StringValue',
					'number' => 42,
				)
			),
			array(
				array(
					'string' => 'DataValues\StringValue',
					'object' => 'stdClass',
				)
			)
		);
	}

	public function testGivenSerializationNoType_deserializeThrowsException() {
		$deserializer = $this->newDeserializer();

		$this->setExpectedException( 'Deserializers\Exceptions\MissingTypeException' );
		$deserializer->deserialize( array() );
	}

	public function testGivenSerializationWithUnknownType_deserializeThrowsException() {
		$deserializer = $this->newDeserializer();

		$this->setExpectedException( 'Deserializers\Exceptions\UnsupportedTypeException' );
		$deserializer->deserialize(
			array(
				'type' => 'ohi'
			)
		);
	}

	public function testGivenSerializationWithNoValue_deserializeThrowsException() {
		$deserializer = $this->newDeserializer();

		$this->setExpectedException( 'Deserializers\Exceptions\MissingAttributeException' );
		$deserializer->deserialize(
			array(
				'type' => 'number'
			)
		);
	}

	/**
	 * @dataProvider invalidDataValueSerializationProvider
	 */
	public function testGivenInvalidDataValue_deserializeThrowsException( $invalidSerialization ) {
		$deserializer = $this->newDeserializer();

		$this->setExpectedException( 'Deserializers\Exceptions\DeserializationException' );
		$deserializer->deserialize( $invalidSerialization );
	}

	public function invalidDataValueSerializationProvider() {
		return array(
			array(
				'foo'
			),

			array(
				null
			),

			array(
				array()
			),

			array(
				array(
					'hax'
				)
			),

			array(
				array(
					'type' => 'hax'
				)
			),

			array(
				array(
					'type' => 'number',
					'value' => array()
				)
			),
		);
	}

	public function testInvalidValueSerialization_throwsDeserializationException() {
		$serialization = array(
			'value' => array( 0, 0 ),
			'type' => 'string',
			'error' => 'omg an error!'
		);

		$deserializer = $this->newDeserializer();
		$this->setExpectedException( 'Deserializers\Exceptions\DeserializationException' );
		$deserializer->deserialize( $serialization );
	}

	/**
	 * @dataProvider dataValueSerializationProvider
	 */
	public function testGivenDataValueSerialization_isDeserializerForReturnsTrue( $dvSerialization ) {
		$deserializer = $this->newDeserializer();
		$this->assertTrue( $deserializer->isDeserializerFor( $dvSerialization ) );
	}

	public function dataValueSerializationProvider() {
		$string = new StringValue( 'foo bar baz' );
		$number = new NumberValue( 42 );

		return array(
			array( $string->toArray(), 'string' ),
			array( $number->toArray(), 'number' ),
		);
	}

	/**
	 * @dataProvider dataValueSerializationProvider
	 */
	public function testGivenDataValueSerialization_deserializeReturnsDataValue( $dvSerialization, $expectedType ) {
		$deserializer = $this->newDeserializer();

		$dataValue = $deserializer->deserialize( $dvSerialization );

		$this->assertInstanceOf( 'DataValues\DataValue', $dataValue );
		$this->assertEquals( $expectedType, $dataValue->getType() );
	}

}

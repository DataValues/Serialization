<?php

namespace Tests\DataValues\Deserializers;

use DataValues\BooleanValue;
use DataValues\DataValue;
use DataValues\Deserializers\DataValueDeserializer;
use DataValues\NumberValue;
use DataValues\StringValue;
use Deserializers\Exceptions\DeserializationException;
use Deserializers\Exceptions\MissingAttributeException;
use Deserializers\Exceptions\MissingTypeException;
use Deserializers\Exceptions\UnsupportedTypeException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DataValues\Deserializers\DataValueDeserializer
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DataValueDeserializerTest extends TestCase {

	public function testGivenEmptyArray_isDeserializerForReturnsFalse() {
		$deserializer = $this->newDeserializer();
		$this->assertFalse( $deserializer->isDeserializerFor( [] ) );
	}

	private function newDeserializer() {
		return new DataValueDeserializer( [
			'boolean' => function( $bool ) {
				return new BooleanValue( $bool );
			},
			'number' => NumberValue::class,
			'string' => StringValue::class,
		] );
	}

	/**
	 * @dataProvider notAnArrayProvider
	 */
	public function testGivenNonArray_isDeserializerForReturnsFalse( $notAnArray ) {
		$deserializer = $this->newDeserializer();
		$this->assertFalse( $deserializer->isDeserializerFor( $notAnArray ) );
	}

	public function notAnArrayProvider() {
		return [
			[ null ],
			[ 0 ],
			[ true ],
			[ new \stdClass() ],
			[ 'foo' ],
		];
	}

	/**
	 * @dataProvider notADataValuesListProvider
	 */
	public function testGivenNonDataValues_constructorThrowsException( array $invalidDVList ) {
		$this->expectException( InvalidArgumentException::class );

		new DataValueDeserializer( $invalidDVList );
	}

	public function notADataValuesListProvider() {
		return [
			[
				[
					'foo',
					null,
					[],
					true,
					42,
				]
			],
			[
				[
					'string' => 'foo',
				]
			],
			[
				[
					'string' => StringValue::class,
					'number' => 42,
				]
			],
			[
				[
					'string' => StringValue::class,
					'object' => 'stdClass',
				]
			]
		];
	}

	public function testGivenSerializationNoType_deserializeThrowsException() {
		$deserializer = $this->newDeserializer();

		$this->expectException( MissingTypeException::class );
		$deserializer->deserialize( [] );
	}

	public function testGivenSerializationWithUnknownType_deserializeThrowsException() {
		$deserializer = $this->newDeserializer();

		$this->expectException( UnsupportedTypeException::class );
		$deserializer->deserialize( [ 'type' => 'ohi', 'value' => null ] );
	}

	public function testGivenSerializationWithNoValue_deserializeThrowsException() {
		$deserializer = $this->newDeserializer();

		$this->expectException( MissingAttributeException::class );
		$deserializer->deserialize( [ 'type' => 'number' ] );
	}

	/**
	 * @dataProvider invalidDataValueSerializationProvider
	 */
	public function testGivenInvalidDataValue_deserializeThrowsException( $invalidSerialization ) {
		$deserializer = $this->newDeserializer();

		$this->expectException( DeserializationException::class );
		$deserializer->deserialize( $invalidSerialization );
	}

	public function invalidDataValueSerializationProvider() {
		return [
			[ 'foo' ],
			[ null ],
			[ [] ],
			[ [ 'hax' ] ],
			[ [ 'type' => 'hax' ] ],
			[ [ 'type' => 'number', 'value' => [] ] ],
			[ [ 'type' => 'boolean', 'value' => 'not a boolean' ] ],
		];
	}

	public function testInvalidValueSerialization_throwsDeserializationException() {
		$serialization = [
			'value' => [ 0, 0 ],
			'type' => 'string',
			'error' => 'omg an error!'
		];

		$deserializer = $this->newDeserializer();
		$this->expectException( DeserializationException::class );
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
		$boolean = new BooleanValue( false );
		$string = new StringValue( 'foo bar baz' );
		$number = new NumberValue( 42 );

		return [
			[ $boolean->toArray(), 'boolean' ],
			[ $string->toArray(), 'string' ],
			[ $number->toArray(), 'number' ],
		];
	}

	/**
	 * @dataProvider dataValueSerializationProvider
	 */
	public function testGivenDataValueSerialization_deserializeReturnsDataValue(
		$dvSerialization,
		$expectedType
	) {
		$deserializer = $this->newDeserializer();

		$dataValue = $deserializer->deserialize( $dvSerialization );

		$this->assertInstanceOf( DataValue::class, $dataValue );
		$this->assertEquals( $expectedType, $dataValue->getType() );
	}

}

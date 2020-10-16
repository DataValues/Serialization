<?php

namespace Tests\DataValues\Serializers;

use DataValues\DataValue;
use DataValues\NumberValue;
use DataValues\Serializers\DataValueSerializer;
use DataValues\StringValue;
use PHPUnit\Framework\TestCase;
use Serializers\Exceptions\SerializationException;

/**
 * @covers \DataValues\Serializers\DataValueSerializer
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DataValueSerializerTest extends TestCase {

	/**
	 * @dataProvider notADataValueProvider
	 */
	public function testGivenNonDataValue_IsSerializerForReturnsFalse( $notAnObject ) {
		$serializer = new DataValueSerializer();

		$this->assertFalse( $serializer->isSerializerFor( $notAnObject ) );
	}

	public function notADataValueProvider() {
		return [
			[ 0 ],
			[ null ],
			[ '' ],
			[ [] ],
			[ true ],
			[ 4.2 ],
			[ new \stdClass() ],
			[ new \Exception() ],
		];
	}

	/**
	 * @dataProvider dataValueProvider
	 */
	public function testGivenDataValue_IsSerializerForReturnsTrue( DataValue $dataValue ) {
		$serializer = new DataValueSerializer();

		$this->assertTrue( $serializer->isSerializerFor( $dataValue ) );
	}

	public function dataValueProvider() {
		return [
			[ new StringValue( 'foo' ) ],
			[ new NumberValue( 42 ) ],
		];
	}

	/**
	 * @dataProvider notADataValueProvider
	 */
	public function testWhenGivenNonDataValue_SerializeThrowsException( $notAnObject ) {
		$serializer = new DataValueSerializer();

		$this->expectException( SerializationException::class );
		$serializer->serialize( $notAnObject );
	}

	public function testWhenGivenDataValue_SerializeCallsToArray() {
		$returnValue = 'expected return value';

		$serializer = new DataValueSerializer();

		$dataValue = $this->createMock( DataValue::class );
		$dataValue->expects( $this->once() )
			->method( 'toArray' )
			->will( $this->returnValue( $returnValue ) );

		$this->assertEquals( $returnValue, $serializer->serialize( $dataValue ) );
	}

}

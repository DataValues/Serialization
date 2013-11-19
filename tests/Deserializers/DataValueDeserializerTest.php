<?php

namespace Tests\DataValues\Deserializers;

use DataValues\Deserializers\DataValueDeserializer;

/**
 * @covers DataValues\Deserializers\DataValueDeserializer
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DataValueDeserializerTest extends \PHPUnit_Framework_TestCase {

	public function testGivenEmptyArray_isDeserializerForReturnsFalse() {
		$deserializer = new DataValueDeserializer();
		$this->assertFalse( $deserializer->isDeserializerFor( array() ) );
	}

}
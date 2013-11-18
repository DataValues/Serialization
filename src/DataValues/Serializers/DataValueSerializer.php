<?php

namespace DataValues\Serializers;

use DataValues\DataValue;
use Serializers\Serializer;

/**
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DataValueSerializer implements Serializer {

	/**
	 * @see Serializer::serialize
	 */
	public function serialize( $object ) {

	}

	/**
	 * @see Serializer::isSerializerFor
	 */
	public function isSerializerFor( $object ) {
		return is_object( $object ) && $object instanceof DataValue;
	}

}

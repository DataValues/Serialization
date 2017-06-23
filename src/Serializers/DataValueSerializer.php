<?php

namespace DataValues\Serializers;

use DataValues\DataValue;
use Serializers\DispatchableSerializer;
use Serializers\Exceptions\UnsupportedObjectException;

/**
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DataValueSerializer implements DispatchableSerializer {

	/**
	 * @see Serializer::serialize
	 *
	 * @param DataValue $object
	 *
	 * @throws UnsupportedObjectException
	 * @return array
	 */
	public function serialize( $object ) {
		if ( $this->isSerializerFor( $object ) ) {
			return $object->toArray();
		}

		throw new UnsupportedObjectException(
			$object,
			'DataValueSerializer can only serialize DataValue objects'
		);
	}

	/**
	 * @see DispatchableSerializer::isSerializerFor
	 *
	 * @param mixed $object
	 *
	 * @return bool
	 */
	public function isSerializerFor( $object ) {
		return $object instanceof DataValue;
	}

}

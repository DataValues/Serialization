<?php

namespace DataValues\Serializers;

use DataValues\DataValue;
use Serializers\DispatchableSerializer;
use Serializers\Exceptions\UnsupportedObjectException;

/**
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DataValueSerializer implements DispatchableSerializer {

	/**
	 * @see Serializer::serialize
	 */
	public function serialize( $object ) {
		if ( $this->isSerializerFor( $object ) ) {
			return $this->getSerializedDataValue( $object );
		}

		throw new UnsupportedObjectException(
			$object,
			'DataValueSerializer can only serialize DataValue objects'
		);
	}

	protected function getSerializedDataValue( DataValue $dataValue ) {
		return $dataValue->toArray();
	}

	/**
	 * @see DispatchableSerializer::isSerializerFor
	 */
	public function isSerializerFor( $object ) {
		return is_object( $object ) && $object instanceof DataValue;
	}

}

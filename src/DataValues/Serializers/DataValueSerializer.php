<?php

namespace DataValues\Serializers;

use DataValues\DataValue;
use Serializers\Exceptions\UnsupportedObjectException;
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
	 * @see Serializer::isSerializerFor
	 */
	public function isSerializerFor( $object ) {
		return is_object( $object ) && $object instanceof DataValue;
	}

}

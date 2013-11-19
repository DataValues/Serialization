<?php

namespace DataValues\Deserializers;

use Deserializers\Deserializer;

/**
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DataValueDeserializer implements Deserializer {

	/**
	 * @see Deserializer::deserialize
	 */
	public function deserialize( $serialization ) {

	}

	/**
	 * @see Deserializer::isDeserializerFor
	 */
	public function isDeserializerFor( $serialization ) {
		return false;
	}

}
<?php

/**
 * Entry point of the DataValues Serialization library.
 *
 * @since 0.1
 * @codeCoverageIgnore
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( defined( 'DATAVALUES_SERIALIZATION_VERSION' ) ) {
	// Do not initialize more then once.
	return 1;
}

define( 'DATAVALUES_SERIALIZATION_VERSION', '0.1 alpha' );

if ( defined( 'MEDIAWIKI' ) ) {
	$GLOBALS['wgExtensionCredits']['datavalues'][] = array(
		'path' => __DIR__,
		'name' => 'DataValues Serialization',
		'version' => DATAVALUES_SERIALIZATION_VERSION,
		'author' => array(
			'[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]'
		),
		'url' => 'https://github.com/DataValues/Serialization',
		'description' => 'Serializers and deserializers for DataValue implementations',
	);
}

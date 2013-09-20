<?php

if ( defined( 'DataValuesCommon_VERSION' ) ) {
	// Do not initialize more then once.
	return;
}

define( 'DATAVALUES_COMMON_VERSION', '0.1 alpha' );

/**
 * @deprecated
 */
define( 'DataValuesCommon_VERSION', DATAVALUES_COMMON_VERSION );

// If one of the dependencies has not been loaded yet, attempt to include the Composer autoloader.
if ( !defined( 'DATAVALUES_VERSION' ) && is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	include_once( __DIR__ . '/vendor/autoload.php' );
}

// Attempt to include the DataValues lib if that hasn't been done yet.
// This is the path the DataValues entry point will be at when loaded as MediaWiki extension.
if ( !defined( 'DATAVALUES_VERSION' ) && is_readable( __DIR__ . '/../DataValues/DataValues.php' ) ) {
	include_once( __DIR__ . '/../DataValues/DataValues.php' );
}

// Attempt to include the DataValuesInterfaces lib if that hasn't been done yet.
// This is the path its entry point will be at when loaded as MediaWiki extension.
if ( !defined( 'DATAVALUES_INTERFACES_VERSION' ) && is_readable( __DIR__ . '/../DataValuesInterfaces/DataValuesInterfaces.php' ) ) {
	include_once( __DIR__ . '/../DataValuesInterfaces/DataValuesInterfaces.php' );
}

// Only initialize the extension when all dependencies are present.
if ( !defined( 'DATAVALUES_VERSION' ) ) {
	throw new Exception( 'You need to have the DataValues library loaded in order to use DataValuesCommon' );
}

// Only initialize the extension when all dependencies are present.
if ( !defined( 'DATAVALUES_INTERFACES_VERSION' ) ) {
	throw new Exception( 'You need to have the DataValuesInterfaces library loaded in order to use DataValuesCommon' );
}

// @codeCoverageIgnoreStart
spl_autoload_register( function ( $className ) {
	static $classes = false;

	if ( $classes === false ) {
		$classes = include( __DIR__ . '/' . 'DataValuesCommon.classes.php' );
	}

	if ( array_key_exists( $className, $classes ) ) {
		include_once __DIR__ . '/' . $classes[$className];
	}
} );

global $wgDataValues;
/**
 * @deprecated since 0.1 This is a global registry that provides no control over object lifecycle
 */
$wgDataValues = array();

// Defined in DataValues core
$wgDataValues['boolean'] = 'DataValues\BooleanValue';
$wgDataValues['number'] = 'DataValues\NumberValue';
$wgDataValues['string'] = 'DataValues\StringValue';
$wgDataValues['unknown'] = 'DataValues\UnknownValue';

// Defined in DataValuesCommon
$wgDataValues['globecoordinate'] = 'DataValues\GlobeCoordinateValue';
$wgDataValues['iri'] = 'DataValues\IriValue';
$wgDataValues['monolingualtext'] = 'DataValues\MonolingualTextValue';
$wgDataValues['multilingualtext'] = 'DataValues\MultilingualTextValue';
$wgDataValues['quantity'] = 'DataValues\QuantityValue';
$wgDataValues['time'] = 'DataValues\TimeValue';

if ( defined( 'MEDIAWIKI' ) ) {
	call_user_func( function() {
		require_once __DIR__ . '/DataValuesCommon.mw.php';
	} );
}
// @codeCoverageIgnoreEnd

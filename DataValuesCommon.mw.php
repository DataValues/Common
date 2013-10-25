<?php

/**
 * @deprecated
 */
define( 'ValueFormatters_VERSION', '0.1 alpha' );

/**
 * @deprecated
 */
define( 'ValueParsers_VERSION', '0.1 alpha' );

/**
 * @deprecated
 */
define( 'ValueValidators_VERSION', '0.1 alpha' );

global $wgValueFormatters;

/**
 * @deprecated since 0.1 This is a global registry that provides no control over object lifecycle
 */
$wgValueFormatters = array(
	'globecoordinate' => 'ValueFormatters\GlobeCoordinateFormatter',
	'time' => 'ValueFormatters\TimeFormatter',
	'string' => 'ValueFormatters\StringFormatter',
);

global $wgValueParsers;

/**
 * @deprecated since 0.1 This is a global registry that provides no control over object lifecycle
 */
$wgValueParsers = array();

$wgValueParsers['bool'] = 'ValueParsers\BoolParser';
$wgValueParsers['float'] = 'ValueParsers\FloatParser';
$wgValueParsers['globecoordinate'] = 'ValueParsers\GlobeCoordinateParser';
$wgValueParsers['int'] = 'ValueParsers\IntParser';
$wgValueParsers['null'] = 'ValueParsers\NullParser';
$wgValueParsers['quantity'] = 'ValueParsers\QuantityParser';

global $wgValueValidators;

/**
 * @deprecated since 0.1 This is a global registry that provides no control over object lifecycle
 */
$wgValueValidators = array();

$wgValueValidators['range'] = 'ValueValidators\RangeValidator';

global $wgExtensionCredits, $wgAPIModules, $wgHooks, $wgValueFormatters;

$wgExtensionCredits['datavalues'][] = array(
	'path' => __DIR__,
	'name' => 'DataValuesCommon',
	'version' => DATAVALUES_COMMON_VERSION,
	'author' => array(
		'[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
		'[https://www.mediawiki.org/wiki/User:Danwe Daniel Werner]',
		'[http://www.snater.com H. Snater]',
	),
	'url' => 'https://github.com/wikimedia/mediawiki-extensions-DataValuesCommon',
	'description' => 'Contains common implementations of the interfaces defined by DataValuesInterfaces',
);

if ( defined( 'MW_PHPUNIT_TEST' ) ) {
	require_once __DIR__ . '/tests/testLoader.php';
}

// API module registration
$wgAPIModules['parsevalue'] = 'ValueParsers\ApiParseValue';

/**
 * Hook to add PHPUnit test cases.
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UnitTestsList
 *
 * @since 0.1
 *
 * @param array $files
 *
 * @return boolean
 */
$wgHooks['UnitTestsList'][] = function( array &$files ) {
	// @codeCoverageIgnoreStart
	$directoryIterator = new RecursiveDirectoryIterator( __DIR__ . '/tests/' );

	/**
	 * @var SplFileInfo $fileInfo
	 */
	foreach ( new RecursiveIteratorIterator( $directoryIterator ) as $fileInfo ) {
		if ( substr( $fileInfo->getFilename(), -8 ) === 'Test.php' ) {
			$files[] = $fileInfo->getPathname();
		}
	}

	return true;
	// @codeCoverageIgnoreEnd
};

/**
 * Hook to add QUnit test cases.
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ResourceLoaderTestModules
 * @since 0.1
 *
 * @param array &$testModules
 * @param \ResourceLoader &$resourceLoader
 * @return boolean
 */
$wgHooks['ResourceLoaderTestModules'][] = function ( array &$testModules, \ResourceLoader &$resourceLoader ) {
	// @codeCoverageIgnoreStart
	$moduleTemplate = array(
		'localBasePath' => __DIR__ . '/js/tests/ValueParsers',
		'remoteExtPath' => 'DataValues/DataValuesCommon/js/tests/ValueParsers',
	);

	$testModules['qunit']['ext.valueParsers.tests'] = $moduleTemplate + array(
			'scripts' => array(
				'ValueParser.tests.js',
			),
			'dependencies' => array(
				'valueParsers.parsers',
			),
		);

	$testModules['qunit']['ext.valueParsers.factory'] = $moduleTemplate + array(
			'scripts' => array(
				'ValueParserFactory.tests.js',
			),
			'dependencies' => array(
				'valueParsers.factory',
				'valueParsers.parsers',
			),
		);

	$testModules['qunit']['ext.valueParsers.parsers'] = $moduleTemplate + array(
			'scripts' => array(
				'parsers/BoolParser.tests.js',
				'parsers/GlobeCoordinateParser.tests.js',
				'parsers/FloatParser.tests.js',
				'parsers/IntParser.tests.js',
				'parsers/StringParser.tests.js',
				'parsers/TimeParser.tests.js',
				'parsers/QuantityParser.tests.js',
				'parsers/NullParser.tests.js',
			),
			'dependencies' => array(
				'ext.valueParsers.tests',
			),
		);

	return true;
	// @codeCoverageIgnoreEnd
};

// Resource Loader module registration
$GLOBALS['wgResourceModules'] = array_merge(
	$GLOBALS['wgResourceModules'],
	include( __DIR__ . '/js/ValueParsers.resources.php' )
);

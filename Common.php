<?php

/**
 * Entry point of the DataValues Common library.
 *
 * @since 0.1
 * @codeCoverageIgnore
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'Common', __DIR__ . '/extension.json' );
	/*wfWarn(
		'Deprecated PHP entry point used for Common extension. Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);*/
	return;
} else {
	die( 'This version of the Common extension requires MediaWiki 1.25+' );


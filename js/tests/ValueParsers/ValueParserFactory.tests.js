/**
 * @file
 * @ingroup ValueParsers
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
( function( vp, $, QUnit, undefined ) {
	'use strict';

	QUnit.module( 'valueParsers.ValueParserFactory.js' );

	QUnit.test(
		'getParserIds',
		function( assert ) {
			var factory = new vp.ValueParserFactory( {} );

			assert.deepEqual( factory.getParserIds(), [], 'Empty factory returns an empty array for getParserIds' );

			factory = new vp.ValueParserFactory( {
				'le-boolean-parser': vp.BoolParser,
				'nyancat-parser': vp.StringParser
			} );

			assert.deepEqual(
				factory.getParserIds(),
				[ 'le-boolean-parser', 'nyancat-parser' ],
				'Non-empty factory returns an array with correct entries for getParserIds'
			);
		}
	);

	QUnit.test(
		'newParser',
		function( assert ) {
			var factory = new vp.ValueParserFactory( {} );
			var nonExistingParsers = [ '', ' ', 'foo', 'foo-bar', '~[,,_,,]:3' ];

			for ( var parserId in nonExistingParsers ) {
				if ( nonExistingParsers.hasOwnProperty( parserId ) ) {
					assert.strictEqual(
						factory.newParser( nonExistingParsers[parserId] ),
						null,
						'Null is returned for non-existing parser "' + nonExistingParsers[parserId] + '"'
					);
				}
			}

			var parsers = {
				'le-boolean-parser': vp.BoolParser,
				'the-same-one': vp.BoolParser,
				'string': vp.StringParser
			};

			factory = new vp.ValueParserFactory( parsers );

			$.each( parsers, function( parserId, parserConstructor ) {
				assert.ok(
					factory.newParser( parserId ) instanceof parserConstructor,
					'Factory correct instantiated "' + parserId + '" parser'
				);
			} );
		}
	);

}( valueParsers, jQuery, QUnit ) );

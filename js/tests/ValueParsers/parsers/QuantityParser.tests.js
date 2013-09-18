/**
 * @licence GNU GPL v2+
 * @author Daniel Werner < daniel.a.r.werner@gmail.com >
 *
 * Constructor for creating a test object holding tests for the QuantityParser data value parser.
 *
 * @since 0.1
 */
valueParsers.tests.QuantityParserTest = ( function(
	inherit, ValueParserTest, QuantityValue, QuantityParser, $
) {
	'use strict';

	var PARENT = ValueParserTest;
	var QuantityParserTest = inherit( PARENT, {
		/**
		 * @see vp.tests.ValueParserTest.getObject
		 */
		getObject: function() {
			return QuantityParser;
		},

		/**
		 * @see vp.tests.ValueParserTest.getParseArguments
		 */
		getParseArguments: function() {
			return [
				[
					'1.5, 1.25',
					new QuantityValue( {} )
				], [
					'-50, -20',
					new QuantityValue( {} )
				]
			];
		}

	} );

	var test = new QuantityParserTest();
	test.runTests( 'valueParsers.QuantityParser' );

	return QuantityParserTest;

}(
	valueParsers.util.inherit,
	valueParsers.tests.ValueParserTest,
	dataValues.QuantityValue,
	valueParsers.QuantityParser,
	jQuery
) );

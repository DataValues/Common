<?php

declare( strict_types = 1 );

namespace ValueParsers\Tests;

use DataValues\NumberValue;
use ValueParsers\FloatParser;

/**
 * @covers \ValueParsers\FloatParser
 * @covers \ValueParsers\StringValueParser
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FloatParserTest extends StringValueParserTest {

	/**
	 * @see ValueParserTestBase::getInstance
	 *
	 * @return FloatParser
	 */
	protected function getInstance() {
		return new FloatParser();
	}

	/**
	 * @see ValueParserTestBase::validInputProvider
	 */
	public function validInputProvider() {
		return [
			// Ignoring a single trailing newline is an intended PCRE feature
			[ "0\n", new NumberValue( 0.0 ) ],

			[ '0', new NumberValue( 0.0 ) ],
			[ '1', new NumberValue( 1.0 ) ],
			[ '42', new NumberValue( 42.0 ) ],
			[ '01', new NumberValue( 1.0 ) ],
			[ '9001', new NumberValue( 9001.0 ) ],
			[ '-1', new NumberValue( -1.0 ) ],
			[ '-42', new NumberValue( -42.0 ) ],

			[ '0.0', new NumberValue( 0.0 ) ],
			[ '1.0', new NumberValue( 1.0 ) ],
			[ '4.2', new NumberValue( 4.2 ) ],
			[ '0.1', new NumberValue( 0.1 ) ],
			[ '90.01', new NumberValue( 90.01 ) ],
			[ '-1.0', new NumberValue( -1.0 ) ],
			[ '-4.2', new NumberValue( -4.2 ) ],
		];
	}

	/**
	 * @see StringValueParserTest::invalidInputProvider
	 */
	public function invalidInputProvider() {
		$argLists = parent::invalidInputProvider();

		$invalid = [
			// Trimming is currently not supported
			' 0 ',

			'foo',
			'',
			'--1',
			'1-',
			'1 1',
			'1,',
			',1',
			',1,',
			'one',
			'0x20',
			'+1',
			'1+1',
			'1-1',
			'1.2.3',
		];

		foreach ( $invalid as $value ) {
			$argLists[] = [ $value ];
		}

		return $argLists;
	}

}

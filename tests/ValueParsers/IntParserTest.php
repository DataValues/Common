<?php

declare( strict_types = 1 );

namespace ValueParsers\Tests;

use DataValues\NumberValue;
use ValueParsers\IntParser;

/**
 * @covers \ValueParsers\IntParser
 * @covers \ValueParsers\StringValueParser
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class IntParserTest extends StringValueParserTest {

	/**
	 * @see ValueParserTestBase::getInstance
	 *
	 * @return IntParser
	 */
	protected function getInstance() {
		return new IntParser();
	}

	/**
	 * @see ValueParserTestBase::validInputProvider
	 */
	public function validInputProvider() {
		return [
			[ '0', new NumberValue( 0 ) ],
			[ '1', new NumberValue( 1 ) ],
			[ '42', new NumberValue( 42 ) ],
			[ '01', new NumberValue( 01 ) ],
			[ '9001', new NumberValue( 9001 ) ],
			[ '-1', new NumberValue( -1 ) ],
			[ '-42', new NumberValue( -42 ) ],
		];
	}

	/**
	 * @see StringValueParserTest::invalidInputProvider
	 */
	public function invalidInputProvider() {
		$argLists = parent::invalidInputProvider();

		$invalid = [
			'foo',
			'4.2',
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

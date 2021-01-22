<?php

declare( strict_types = 1 );

namespace ValueParsers\Tests;

use DataValues\BooleanValue;
use ValueParsers\BoolParser;

/**
 * @covers \ValueParsers\BoolParser
 * @covers \ValueParsers\StringValueParser
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class BoolParserTest extends StringValueParserTest {

	/**
	 * @see ValueParserTestBase::getInstance
	 *
	 * @return BoolParser
	 */
	protected function getInstance() {
		return new BoolParser();
	}

	/**
	 * @see ValueParserTestBase::validInputProvider
	 */
	public function validInputProvider() {
		return [
			[ 'yes', new BooleanValue( true ) ],
			[ 'on', new BooleanValue( true ) ],
			[ '1', new BooleanValue( true ) ],
			[ 'true', new BooleanValue( true ) ],
			[ 'no', new BooleanValue( false ) ],
			[ 'off', new BooleanValue( false ) ],
			[ '0', new BooleanValue( false ) ],
			[ 'false', new BooleanValue( false ) ],

			[ 'YeS', new BooleanValue( true ) ],
			[ 'ON', new BooleanValue( true ) ],
			[ 'No', new BooleanValue( false ) ],
			[ 'OfF', new BooleanValue( false ) ],
		];
	}

	/**
	 * @see StringValueParserTest::invalidInputProvider
	 */
	public function invalidInputProvider() {
		$argLists = parent::invalidInputProvider();

		$invalid = [
			'foo',
			'2',
		];

		foreach ( $invalid as $value ) {
			$argLists[] = [ $value ];
		}

		return $argLists;
	}

}

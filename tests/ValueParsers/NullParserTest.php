<?php

declare( strict_types = 1 );

namespace ValueParsers\Tests;

use DataValues\UnknownValue;
use ValueParsers\NullParser;
use ValueParsers\ValueParser;

/**
 * @covers \ValueParsers\NullParser
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class NullParserTest extends ValueParserTestBase {

	/**
	 * @see ValueParserTestBase::getInstance
	 *
	 * @return NullParser
	 */
	protected function getInstance() {
		return new NullParser();
	}

	/**
	 * @see ValueParserTestBase::validInputProvider
	 */
	public function validInputProvider() {
		return [
			[ '42', new UnknownValue( '42' ) ],
			[ 42, new UnknownValue( 42 ) ],
			[ false, new UnknownValue( false ) ],
			[ [], new UnknownValue( [] ) ],
			[ 'ohi there!', new UnknownValue( 'ohi there!' ) ],
			[ null, new UnknownValue( null ) ],
			[ 4.2, new UnknownValue( 4.2 ) ],
		];
	}

	/**
	 * @see ValueParserTestBase::invalidInputProvider
	 */
	public function invalidInputProvider() {
		return [ [ null ] ];
	}

	/**
	 * @see ValueParserTestBase::testParseWithInvalidInputs
	 *
	 * @dataProvider invalidInputProvider
	 */
	public function testParseWithInvalidInputs( $value, ValueParser $parser = null ) {
		$this->markTestSkipped( 'NullParser has no invalid inputs' );
	}

}

<?php

declare( strict_types = 1 );

namespace ValueParsers\Tests;

use ValueParsers\ParserOptions;
use ValueParsers\StringValueParser;

/**
 * @covers \ValueParsers\StringValueParser
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class StringValueParserTest extends ValueParserTestBase {

	/**
	 * @see ValueParserTestBase::invalidInputProvider
	 */
	public function invalidInputProvider() {
		return [
			[ true ],
			[ false ],
			[ null ],
			[ 4.2 ],
			[ [] ],
			[ 42 ],
		];
	}

	public function testSetAndGetOptions() {
		/** @var StringValueParser $parser */
		$parser = $this->getInstance();
		$options = new ParserOptions();
		$parser->setOptions( $options );
		$this->assertSame( $options, $parser->getOptions() );
	}

}

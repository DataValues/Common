<?php

declare( strict_types = 1 );

namespace ValueParsers\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ValueParsers\DispatchingValueParser;
use ValueParsers\ParseException;
use ValueParsers\ValueParser;

/**
 * @covers \ValueParsers\DispatchingValueParser
 *
 * @group DataValue
 * @group DataValueExtensions
 * @group ValueParsers
 *
 * @license GPL-2.0-or-later
 * @author Thiemo Kreuz
 */
class DispatchingValueParserTest extends TestCase {

	private function getParser( $invocation ) : ValueParser {
		$mock = $this->createMock( ValueParser::class );

		$mock->expects( $invocation )
			->method( 'parse' )
			->will( $this->returnCallback( function( $value ) {
				if ( $value === 'invalid' ) {
					throw new ParseException( 'failed' );
				}
				return $value;
			} ) );

		return $mock;
	}

	/**
	 * @dataProvider invalidConstructorArgumentsProvider
	 */
	public function testGivenInvalidConstructorArguments_constructorThrowsException( $parsers, $format ) {
		$this->expectException( InvalidArgumentException::class );
		new DispatchingValueParser( $parsers, $format );
	}

	public function invalidConstructorArgumentsProvider() {
		$parsers = [
			$this->getParser( $this->never() ),
		];

		return [
			[ [], 'format' ],
			[ $parsers, null ],
			[ $parsers, '' ],
		];
	}

	public function testParse() {
		$parser = new DispatchingValueParser(
			[
				$this->getParser( $this->once() ),
				$this->getParser( $this->never() ),
			],
			'format'
		);

		$this->assertEquals( 'valid', $parser->parse( 'valid' ) );
	}

	public function testParseThrowsException() {
		$parser = new DispatchingValueParser(
			[
				$this->getParser( $this->once() ),
			],
			'format'
		);

		$this->expectException( ParseException::class );
		$parser->parse( 'invalid' );
	}

}

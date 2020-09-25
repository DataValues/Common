<?php

namespace ValueParsers\Test;

use DataValues\DataValue;
use DataValues\StringValue;
use ValueParsers\Normalizers\StringNormalizer;
use ValueParsers\ParseException;
use ValueParsers\StringParser;

/**
 * @covers \ValueParsers\StringParser
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Daniel Kinzler
 */
class StringParserTest extends \PHPUnit_Framework_TestCase {

	public function provideParse() {
		$normalizer = $this->getMock( StringNormalizer::class );
		$normalizer->expects( $this->once() )
			->method( 'normalize' )
			->will( $this->returnCallback( function( $value ) {
				return strtolower( trim( $value ) );
			} ) );

		return [
			'simple' => [ 'hello world', null, new StringValue( 'hello world' ) ],
			'normalize' => [ '  Hello World  ', $normalizer, new StringValue( 'hello world' ) ],
		];
	}

	/**
	 * @dataProvider provideParse
	 */
	public function testParse( $input, StringNormalizer $normalizer = null, DataValue $expected ) {
		$parser = new StringParser( $normalizer );
		$value = $parser->parse( $input );

		$this->assertInstanceOf( StringValue::class, $value );
		$this->assertEquals( $expected->toArray(), $value->toArray() );
	}

	public function nonStringProvider() {
		return [
			'null' => [ null ],
			'array' => [ [] ],
			'int' => [ 7 ],
		];
	}

	/**
	 * @dataProvider nonStringProvider
	 */
	public function testGivenNonString_parseThrowsException( $input ) {
		$parser = new StringParser();
		$this->setExpectedException( ParseException::class );
		$parser->parse( $input );
	}

}

<?php

namespace ValueParsers\Test;

use DataValues\DataValue;
use DataValues\StringValue;
use ValueParsers\StringParser;

/**
 * Unit test StringParser class.
 *
 * @covers StringParser
 *
 * @since 0.1
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class StringParserTest extends \PHPUnit_Framework_TestCase {

	public function provideParse() {
		$normalizer = $this->getMock( 'ValueParsers\Normalizers\StringNormalizer' );
		$normalizer->expects( $this->once() )
			->method( 'normalize' )
			->will( $this->returnCallback( function( $value ) {
				return strtolower( trim( $value ) );
			} ) );

		return array(
			'simple' => array( 'hello world', null, new StringValue( 'hello world' ) ),
			'normalize' => array( '  Hello World  ', $normalizer, new StringValue( 'hello world' ) ),
		);
	}

	/**
	 * @dataProvider provideParse
	 */
	public function testParse( $input, $normalizer, DataValue $expected ) {
		$parser = new StringParser( $normalizer );
		$value = $parser->parse( $input );

		$this->assertInstanceOf( 'DataValues\StringValue', $value );
		$this->assertEquals( $expected->toArray(), $value->toArray() );
	}

	public function provideParse_InvalidArgumentException() {
		return array(
			'null' => array( null ),
			'array' => array( array() ),
			'int' => array( 7 ),
		);
	}

	/**
	 * @dataProvider provideParse_InvalidArgumentException
	 */
	public function testParse_InvalidArgumentException( $input ) {
		$this->setExpectedException( 'InvalidArgumentException' );

		$parser = new StringParser();
		$parser->parse( $input );
	}

}

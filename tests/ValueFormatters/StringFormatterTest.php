<?php

declare( strict_types = 1 );

namespace ValueFormatters\Tests;

use DataValues\StringValue;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ValueFormatters\StringFormatter;

/**
 * @covers \ValueFormatters\StringFormatter
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @license GPL-2.0-or-later
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class StringFormatterTest extends TestCase {

	/** @dataProvider validProvider */
	public function testValidFormat( StringValue $value, string $expected ) {
		$formatter = new StringFormatter();
		$this->assertSame( $expected, $formatter->format( $value ) );
	}

	public function validProvider() {
		return [
			[ new StringValue( 'ice cream' ), 'ice cream' ],
			[ new StringValue( 'cake' ), 'cake' ],
			[ new StringValue( '' ), '' ],
			[ new StringValue( ' a ' ), ' a ' ],
			[ new StringValue( '  ' ), '  ' ],
		];
	}

	/**
	 * @dataProvider invalidProvider
	 */
	public function testInvalidFormat( $value ) {
		$formatter = new StringFormatter();
		$this->expectException( InvalidArgumentException::class );
		$formatter->format( $value );
	}

	public function invalidProvider() {
		return [
			[ null ],
			[ 0 ],
			[ '' ],
		];
	}

}

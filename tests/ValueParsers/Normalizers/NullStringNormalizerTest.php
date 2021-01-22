<?php

declare( strict_types = 1 );

namespace ValueParsers\Tests\Normalizers;

use DataValues\StringValue;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ValueParsers\Normalizers\NullStringNormalizer;

/**
 * @covers \ValueParsers\Normalizers\NullStringNormalizer
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @license GPL-2.0-or-later
 * @author Thiemo Kreuz
 */
class NullStringNormalizerTest extends TestCase {

	/**
	 * @dataProvider stringProvider
	 */
	public function testNormalize( $value ) {
		$normalizer = new NullStringNormalizer();
		$this->assertSame( $value, $normalizer->normalize( $value ) );
	}

	public function stringProvider() {
		return [
			[ '' ],
			[ 'a' ],
			[ ' a ' ],
		];
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	public function testNormalizeException( $value ) {
		$normalizer = new NullStringNormalizer();
		$this->expectException( InvalidArgumentException::class );
		$normalizer->normalize( $value );
	}

	public function invalidValueProvider() {
		return [
			[ null ],
			[ true ],
			[ 1 ],
			[ new StringValue( '' ) ],
		];
	}

}

<?php

namespace ValueParsers\Normalizers\Test;

use DataValues\StringValue;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use ValueParsers\Normalizers\NullStringNormalizer;

/**
 * @covers ValueParsers\Normalizers\NullStringNormalizer
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Thiemo Kreuz
 */
class NullStringNormalizerTest extends PHPUnit_Framework_TestCase {

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
		$this->setExpectedException( InvalidArgumentException::class );
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

<?php

declare( strict_types = 1 );

namespace DataValues\Tests;

use DataValues\IllegalValueException;
use DataValues\MonolingualTextValue;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DataValues\MonolingualTextValue
 *
 * @since 0.1
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MonolingualTextValueTest extends TestCase {

	public function testGetters() {
		$value = new MonolingualTextValue( 'en', 'foo' );
		$this->assertSame( 'monolingualtext', $value->getType() );
		$this->assertSame( 'enfoo', $value->getSortKey() );
		$this->assertSame( 'foo', $value->getText() );
		$this->assertSame( 'en', $value->getLanguageCode() );
	}

	public function testArrayAndEquals() {
		$value = new MonolingualTextValue( 'en', 'foo' );
		$array = $value->getArrayValue();
		$value2 = MonolingualTextValue::newFromArray( $array );
		$this->assertTrue( $value->equals( $value2 ) );
		$this->assertEquals( $value, $value2 );
	}

	public function testSerialize() {
		$value = new MonolingualTextValue( 'en', 'foo' );
		$serialization = serialize( $value );
		$value2 = unserialize( $serialization );
		$this->assertEquals( $value, $value2 );
	}

	/**
	 * @dataProvider invalidConstructorArgumentsProvider
	 */
	public function testConstructorWithInvalidArguments( $languageCode, $text ) {
		$this->expectException( Exception::class );

		$dataItem = new MonolingualTextValue( $languageCode, $text );
	}

	public function invalidConstructorArgumentsProvider() {
		return [
			[ 42, null ],
			[ [], null ],
			[ false, null ],
			[ true, null ],
			[ null, null ],
			[ 'en', 42 ],
			[ 'en', false ],
			[ 'en', [] ],
			[ 'en', null ],
			[ '', 'foo' ],
		];
	}

	/**
	 * @dataProvider invalidArrayProvider
	 */
	public function testNewFromArrayWithInvalidArray( array $array ) {
		$this->expectException( IllegalValueException::class );
		MonolingualTextValue::newFromArray( $array );
	}

	public function invalidArrayProvider() {
		return [
			[ [] ],
			[ [ null ] ],
			[ [ '' ] ],
			[ [ 'en', 'foo' ] ],
			[ [ 'language' => 'en' ] ],
			[ [ 'text' => 'foo' ] ],
		];
	}

}

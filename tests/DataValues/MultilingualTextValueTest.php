<?php

declare( strict_types = 1 );

namespace DataValues\Tests;

use DataValues\IllegalValueException;
use DataValues\MonolingualTextValue;
use DataValues\MultilingualTextValue;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DataValues\MultilingualTextValue
 *
 * @since 0.1
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MultilingualTextValueTest extends TestCase {

	public function testGetters() {
		$monolingualTextValue1 = new MonolingualTextValue( 'en', 'foo' );
		$monolingualTextValue2 = new MonolingualTextValue( 'de', 'foo' );
		$value = new MultilingualTextValue( [ $monolingualTextValue1, $monolingualTextValue2 ] );
		$this->assertSame( 'multilingualtext', $value->getType() );
		$this->assertSame( 'enfoo', $value->getSortKey() );
		$this->assertSame(
			[ 'en' => $monolingualTextValue1, 'de' => $monolingualTextValue2 ],
			$value->getTexts()
		);
	}

	public function testGetters_empty() {
		$value = new MultilingualTextValue( [] );
		$this->assertSame( '', $value->getSortKey() );
		$this->assertSame( [], $value->getTexts() );
	}

	public function testArrayAndEquals() {
		$monolingualTextValue1 = new MonolingualTextValue( 'en', 'foo' );
		$monolingualTextValue2 = new MonolingualTextValue( 'de', 'foo' );
		$value = new MultilingualTextValue( [ $monolingualTextValue1, $monolingualTextValue2 ] );
		$array = $value->getArrayValue();
		$value2 = MultilingualTextValue::newFromArray( $array );
		$this->assertTrue( $value->equals( $value2 ) );
		$this->assertEquals( $value, $value2 );
	}

	public function testSerialize() {
		$monolingualTextValue1 = new MonolingualTextValue( 'en', 'foo' );
		$monolingualTextValue2 = new MonolingualTextValue( 'de', 'foo' );
		$value = new MultilingualTextValue( [ $monolingualTextValue1, $monolingualTextValue2 ] );
		$serialization = serialize( $value );
		$value2 = unserialize( $serialization );
		$this->assertEquals( $value, $value2 );
	}

	/**
	 * @dataProvider invalidConstructorArgumentsProvider
	 */
	public function testConstructorWithInvalidArguments( $monolingualValues ) {
		$this->expectException( Exception::class );

		$dataItem = new MultilingualTextValue( $monolingualValues );
	}

	public function invalidConstructorArgumentsProvider() {
		return [
			[ [ 42 ] ],
			[ [ false ] ],
			[ [ true ] ],
			[ [ null ] ],
			[ [ [] ] ],
			[ [ 'foo' ] ],

			[ [ 42 => 'foo' ] ],
			[ [ '' => 'foo' ] ],
			[ [ 'en' => 42 ] ],
			[ [ 'en' => null ] ],
			[ [ 'en' => true ] ],
			[ [ 'en' => [] ] ],
			[ [ 'en' => 4.2 ] ],

			[ [
				new MonolingualTextValue( 'en', 'foo' ),
				false,
			] ],
			[ [
				new MonolingualTextValue( 'en', 'foo' ),
				'foobar',
			] ],
			[ [
				new MonolingualTextValue( 'en', 'foo' ),
				new MonolingualTextValue( 'en', 'bar' ),
			] ],
		];
	}

	/**
	 * @dataProvider invalidArrayProvider
	 */
	public function testNewFromArrayWithInvalidArray( array $array ) {
		$this->expectException( IllegalValueException::class );
		MultilingualTextValue::newFromArray( $array );
	}

	public function invalidArrayProvider() {
		return [
			[ [ null ] ],
			[ [ '' ] ],
			[ [ [] ] ],
			[ [ [ 'en', 'foo' ] ] ],
		];
	}

}

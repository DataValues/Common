<?php

namespace DataValues\Tests;

use DataValues\MonolingualTextValue;

/**
 * @covers DataValues\MonolingualTextValue
 *
 * @since 0.1
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MonolingualTextValueTest extends DataValueTest {

	/**
	 * @see DataValueTest::getClass
	 *
	 * @return string
	 */
	public function getClass() {
		return 'DataValues\MonolingualTextValue';
	}

	public function validConstructorArgumentsProvider() {
		return [
			[ 'en', 'foo' ],
			[ 'en', ' foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz ' ],
		];
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

	public function testNewFromArray() {
		$array = [ 'text' => 'foo', 'language' => 'en' ];
		$value = MonolingualTextValue::newFromArray( $array );
		$this->assertSame( $array, $value->getArrayValue() );
	}

	/**
	 * @dataProvider invalidArrayProvider
	 */
	public function testNewFromArrayWithInvalidArray( array $array ) {
		$this->setExpectedException( 'DataValues\IllegalValueException' );
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

	public function testGetSortKey() {
		$value = new MonolingualTextValue( 'en', 'foo' );
		$this->assertSame( 'enfoo', $value->getSortKey() );
	}

	/**
	 * @dataProvider instanceProvider
	 */
	public function testGetText( MonolingualTextValue $text, array $arguments ) {
		$this->assertEquals( $arguments[1], $text->getText() );
	}

	/**
	 * @dataProvider instanceProvider
	 */
	public function testGetLanguageCode( MonolingualTextValue $text, array $arguments ) {
		$this->assertEquals( $arguments[0], $text->getLanguageCode() );
	}

}

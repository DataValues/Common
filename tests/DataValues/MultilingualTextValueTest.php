<?php

namespace DataValues\Tests;

use DataValues\IllegalValueException;
use DataValues\MonolingualTextValue;
use DataValues\MultilingualTextValue;

/**
 * @covers DataValues\MultilingualTextValue
 *
 * @since 0.1
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MultilingualTextValueTest extends DataValueTest {

	/**
	 * @see DataValueTest::getClass
	 *
	 * @return string
	 */
	public function getClass() {
		return MultilingualTextValue::class;
	}

	public function validConstructorArgumentsProvider() {
		return [
			[ [] ],
			[ [
				new MonolingualTextValue( 'en', 'foo' ),
			] ],
			[ [
				new MonolingualTextValue( 'en', 'foo' ),
				new MonolingualTextValue( 'de', 'foo' ),
			] ],
			[ [
				new MonolingualTextValue( 'en', 'foo' ),
				new MonolingualTextValue( 'de', 'bar' ),
			] ],
			[ [
				new MonolingualTextValue( 'en', 'foo' ),
				new MonolingualTextValue( 'de', ' foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz ' ),
			] ],
		];
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

	public function testNewFromArray() {
		$array = [ [ 'text' => 'foo', 'language' => 'en' ] ];
		$value = MultilingualTextValue::newFromArray( $array );
		$this->assertSame( $array, $value->getArrayValue() );
	}

	/**
	 * @dataProvider invalidArrayProvider
	 */
	public function testNewFromArrayWithInvalidArray( array $array ) {
		$this->setExpectedException( IllegalValueException::class );
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

	/**
	 * @dataProvider getSortKeyProvider
	 */
	public function testGetSortKey( array $monolingualValues, $expected ) {
		$value = new MultilingualTextValue( $monolingualValues );
		$this->assertSame( $expected, $value->getSortKey() );
	}

	public function getSortKeyProvider() {
		return [
			[ [], '' ],
			[ [
				new MonolingualTextValue( 'en', 'foo' ),
			], 'enfoo' ],
			[ [
				new MonolingualTextValue( 'en', 'foo' ),
				new MonolingualTextValue( 'de', 'bar' ),
			], 'enfoo' ],
		];
	}

	/**
	 * @dataProvider instanceProvider
	 */
	public function testGetTexts( MultilingualTextValue $texts, array $arguments ) {
		$actual = $texts->getTexts();

		$this->assertInternalType( 'array', $actual );
		$this->assertContainsOnlyInstancesOf( MonolingualTextValue::class, $actual );
		$this->assertEquals( $arguments[0], array_values( $actual ) );
	}

	/**
	 * @dataProvider instanceProvider
	 */
	public function testGetValue( MultilingualTextValue $texts, array $arguments ) {
		$this->assertInstanceOf( $this->getClass(), $texts->getValue() );
	}

}

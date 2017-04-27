<?php

namespace DataValues\Tests;

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
		return 'DataValues\MultilingualTextValue';
	}

	public function validConstructorArgumentsProvider() {
		$argLists = [];

		$argLists[] = [ [] ];
		$argLists[] = [ [ new MonolingualTextValue( 'en', 'foo' ) ] ];
		$argLists[] = [ [ new MonolingualTextValue( 'en', 'foo' ), new MonolingualTextValue( 'de', 'foo' ) ] ];
		$argLists[] = [ [ new MonolingualTextValue( 'en', 'foo' ), new MonolingualTextValue( 'de', 'bar' ) ] ];
		$argLists[] = [ [
			new MonolingualTextValue( 'en', 'foo' ),
			new MonolingualTextValue( 'de', ' foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz foo bar baz ' )
		] ];

		return $argLists;
	}

	public function invalidConstructorArgumentsProvider() {
		$argLists = [];

		$argLists[] = [ [ 42 ] ];
		$argLists[] = [ [ false ] ];
		$argLists[] = [ [ true ] ];
		$argLists[] = [ [ null ] ];
		$argLists[] = [ [ [] ] ];
		$argLists[] = [ [ 'foo' ] ];

		$argLists[] = [ [ 42 => 'foo' ] ];
		$argLists[] = [ [ '' => 'foo' ] ];
		$argLists[] = [ [ 'en' => 42 ] ];
		$argLists[] = [ [ 'en' => null ] ];
		$argLists[] = [ [ 'en' => true ] ];
		$argLists[] = [ [ 'en' => [] ] ];
		$argLists[] = [ [ 'en' => 4.2 ] ];

		$argLists[] = [ [ new MonolingualTextValue( 'en', 'foo' ), false ] ];
		$argLists[] = [ [ new MonolingualTextValue( 'en', 'foo' ), 'foobar' ] ];

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 */
	public function testGetTexts( MultilingualTextValue $texts, array $arguments ) {
		$actual = $texts->getTexts();

		$this->assertInternalType( 'array', $actual );
		$this->assertContainsOnlyInstancesOf( '\DataValues\MonolingualTextValue', $actual );
		$this->assertEquals( $arguments[0], array_values( $actual ) );
	}

	/**
	 * @dataProvider instanceProvider
	 */
	public function testGetValue( MultilingualTextValue $texts, array $arguments ) {
		$this->assertInstanceOf( $this->getClass(), $texts->getValue() );
	}

}

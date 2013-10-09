<?php

namespace DataValues\Tests;

use DataValues\DecimalValue;

/**
 * @covers DataValues\DecimalValue
 *
 * @since 0.1
 *
 * @ingroup DataValue
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 *
 * @author Daniel Kinzler
 */
class DecimalValueTest extends DataValueTest {

	/**
	 * @see DataValueTest::getClass
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getClass() {
		return 'DataValues\DecimalValue';
	}

	public function validConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( 42 );
		$argLists[] = array( -42 );
		$argLists[] = array( '-42' );
		$argLists[] = array( 4.2 );
		$argLists[] = array( -4.2 );
		$argLists[] = array( '+4.2' );
		$argLists[] = array( 0 );
		$argLists[] = array( 0.2 );
		$argLists[] = array( '-0.42' );
		$argLists[] = array( '-0.0' );
		$argLists[] = array( '-0' );
		$argLists[] = array( '+0.0' );
		$argLists[] = array( '+0' );

		return $argLists;
	}

	public function invalidConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array();


		$argLists[] = array( 'foo' );
		$argLists[] = array( '' );
		$argLists[] = array( '4.2' );
		$argLists[] = array( '++4.2' );
		$argLists[] = array( '--4.2' );
		$argLists[] = array( '-+4.2' );
		$argLists[] = array( '+-4.2' );
		$argLists[] = array( '-.42' );
		$argLists[] = array( '+.42' );
		$argLists[] = array( '.42' );
		$argLists[] = array( '.0' );
		$argLists[] = array( '-00' );
		$argLists[] = array( '+01.2' );
		$argLists[] = array( 'x2' );
		$argLists[] = array( '2x' );
		$argLists[] = array( '+0100' );
		$argLists[] = array( false );
		$argLists[] = array( true );
		$argLists[] = array( null );
		$argLists[] = array( '0x20' );

		return $argLists;
	}

	/**
	 * @dataProvider compareProvider
	 *
	 * @since 0.1
	 */
	public function testCompare( DecimalValue $a, DecimalValue $b, $expected ) {
		$actual = $a->compare( $b );
		$this->assertSame( $expected, $actual );

		$actual = $b->compare( $a );
		$this->assertSame( -$expected, $actual );
	}

	public function compareProvider() {
		return array(
			'zero/equal' => array( new DecimalValue( 0 ), new DecimalValue( 0 ), 0 ),
			'zero-signs/equal' => array( new DecimalValue( '+0' ), new DecimalValue( '-0' ), 0 ),
			'zero-digits/equal' => array( new DecimalValue( '+0' ), new DecimalValue( '+0.000' ), 0 ),
			'digits/equal' => array( new DecimalValue( '+2.2' ), new DecimalValue( '+2.2000' ), 0 ),
			'conversion/equal' => array( new DecimalValue( 2.5 ), new DecimalValue( '+2.50' ), 0 ),
			'negative/equal' => array( new DecimalValue( '-1.33' ), new DecimalValue( '-1.33' ), 0 ),

			'simple/smaller' => array( new DecimalValue( '+1' ), new DecimalValue( '+2' ), -1 ),
			'simple/greater' => array( new DecimalValue( '+2' ), new DecimalValue( '+1' ), +1 ),
			'negative/greater' => array( new DecimalValue( '-1' ), new DecimalValue( '-2' ), +1 ),
			'negative/smaller' => array( new DecimalValue( '-2' ), new DecimalValue( '-1' ), -1 ),

			'digits/greater' => array( new DecimalValue( '+11' ), new DecimalValue( '+8' ), +1 ),
			'digits-sub/greater' => array( new DecimalValue( '+11' ), new DecimalValue( '+8.0' ), +1 ),
			'negative-digits/greater' => array( new DecimalValue( '-11' ), new DecimalValue( '-80' ), +1 ),
			'small/greater' => array( new DecimalValue( '+0.050' ), new DecimalValue( '+0.005' ), +1 ),

			'signs/greater' => array( new DecimalValue( '+1' ), new DecimalValue( '-8' ), +1 ),
			'signs/less' => array( new DecimalValue( '-8' ), new DecimalValue( '+1' ), -1 ),
		);
	}

	/**
	 * @dataProvider getSignProvider
	 *
	 * @since 0.1
	 */
	public function testGetSign( DecimalValue $value, $expected ) {
		$actual = $value->getSign();
		$this->assertSame( $expected, $actual );
	}

	public function getSignProvider() {
		return array(
			'zero is positive' => array( new DecimalValue( 0 ), '+' ),
			'zero is always positive' => array( new DecimalValue( '-0' ), '+' ),
			'zero is ALWAYS positive' => array( new DecimalValue( '-0.00' ), '+' ),
			'+1 is positive' => array( new DecimalValue( '+1' ), '+' ),
			'-1 is negative' => array( new DecimalValue( '-1' ), '-' ),
			'+0.01 is positive' => array( new DecimalValue( '+0.01' ), '+' ),
			'-0.01 is negative' => array( new DecimalValue( '-0.01' ), '-' ),
		);
	}

	/**
	 * @dataProvider getValueProvider
	 *
	 * @since 0.1
	 */
	public function testGetValue( DecimalValue $value, $expected ) {
		$actual = $value->getValue();
		$this->assertSame( $expected, $actual );
	}

	public function getValueProvider() {
		$argLists = array();

		$argLists[] = array( new DecimalValue( 42 ), '+42' );
		$argLists[] = array( new DecimalValue( -42 ), '-42' );
		$argLists[] = array( new DecimalValue( '-42' ), '-42' );
		$argLists[] = array( new DecimalValue( 4.5 ), '+4.5' );
		$argLists[] = array( new DecimalValue( -4.5 ), '-4.5' );
		$argLists[] = array( new DecimalValue( '+4.2' ), '+4.2' );
		$argLists[] = array( new DecimalValue( 0 ), '+0' );
		$argLists[] = array( new DecimalValue( 0.5 ), '+0.5' );
		$argLists[] = array( new DecimalValue( '-0.42' ), '-0.42' );
		$argLists[] = array( new DecimalValue( '-0.0' ), '+0.0' );
		$argLists[] = array( new DecimalValue( '-0' ), '+0' );
		$argLists[] = array( new DecimalValue( '+0.0' ), '+0.0' );
		$argLists[] = array( new DecimalValue( '+0' ), '+0' );

		return $argLists;
	}

	/**
	 * @dataProvider getValueFloatProvider
	 *
	 * @since 0.1
	 */
	public function testGetValueFloat( DecimalValue $value, $expected ) {
		$actual = $value->getValueFloat();
		$this->assertSame( $expected, $actual );
	}

	public function getValueFloatProvider() {
		$argLists = array();

		$argLists[] = array( new DecimalValue( 42 ), 42.0 );
		$argLists[] = array( new DecimalValue( -42 ), -42.0 );
		$argLists[] = array( new DecimalValue( '-42' ), -42.0 );
		$argLists[] = array( new DecimalValue( 4.5 ), 4.5 );
		$argLists[] = array( new DecimalValue( -4.5 ), -4.5 );
		$argLists[] = array( new DecimalValue( '+4.2' ), 4.2 );
		$argLists[] = array( new DecimalValue( 0 ), 0.0 );
		$argLists[] = array( new DecimalValue( 0.5 ), 0.5 );
		$argLists[] = array( new DecimalValue( '-0.42' ), -0.42 );
		$argLists[] = array( new DecimalValue( '-0.0' ), 0.0 );
		$argLists[] = array( new DecimalValue( '-0' ), 0.0 );
		$argLists[] = array( new DecimalValue( '+0.0' ), 0.0 );
		$argLists[] = array( new DecimalValue( '+0' ), 0.0 );

		return $argLists;
	}
}

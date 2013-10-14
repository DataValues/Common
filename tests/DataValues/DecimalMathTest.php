<?php

namespace DataValues\Tests;

use DataValues\DecimalMath;
use DataValues\DecimalValue;

/**
 * @covers DataValues\DecimalMathTest
 *
 * @since 0.1
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 *
 * @author Daniel Kinzler
 */
class DecimalMathTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider bumpProvider
	 *
	 * @since 0.1
	 */
	public function testBump( DecimalValue $value, $expected ) {
		$math = new DecimalMath();
		$actual = $math->bump( $value );
		$this->assertSame( $expected, $actual->getValue() );
	}

	public function bumpProvider() {
		return array(
			array( new DecimalValue(  '+0' ),   '+1' ),
			array( new DecimalValue(  '-0' ),   '+1' ),
			array( new DecimalValue(  '+0.0' ), '+0.1' ),
			array( new DecimalValue(  '-0.0' ), '+0.1' ),
			array( new DecimalValue(  '+1' ),   '+2' ),
			array( new DecimalValue(  '-1' ),   '-2' ),
			array( new DecimalValue( '+10' ),  '+11' ),
			array( new DecimalValue( '-10' ),  '-11' ),
			array( new DecimalValue(  '+9' ),  '+10' ),
			array( new DecimalValue(  '-9' ),  '-10' ),
			array( new DecimalValue( '+0.01' ), '+0.02' ),
			array( new DecimalValue( '-0.01' ), '-0.02' ),
			array( new DecimalValue( '+0.09' ), '+0.10' ),
			array( new DecimalValue( '-0.09' ), '-0.10' ),
			array( new DecimalValue( '+0.9' ),  '+1.0' ),
			array( new DecimalValue( '-0.9' ),  '-1.0' ),
		);
	}

	/**
	 * @dataProvider slumpProvider
	 *
	 * @since 0.1
	 */
	public function testSlump( DecimalValue $value, $expected ) {
		$math = new DecimalMath();
		$actual = $math->slump( $value );
		$this->assertSame( $expected, $actual->getValue() );
	}

	public function slumpProvider() {
		return array(
			array( new DecimalValue(  '+0' ),    '-1' ),
			array( new DecimalValue(  '-0' ),    '-1' ),
			array( new DecimalValue(  '+0.0' ),  '-0.1' ),
			array( new DecimalValue(  '-0.0' ),  '-0.1' ),
			array( new DecimalValue(  '+0.00' ),  '-0.01' ),
			array( new DecimalValue(  '-0.00' ),  '-0.01' ),
			array( new DecimalValue(  '+1' ),    '+0' ),
			array( new DecimalValue(  '-1' ),    '+0' ),
			array( new DecimalValue(  '+1.0' ),  '+0.9' ),
			array( new DecimalValue(  '-1.0' ),  '-0.9' ),
			array( new DecimalValue(  '+0.1' ),  '+0.0' ),
			array( new DecimalValue(  '-0.1' ),  '+0.0' ), // zero is always normalized to be positive
			array( new DecimalValue(  '+0.01' ), '+0.00' ),
			array( new DecimalValue(  '-0.01' ), '+0.00' ), // zero is always normalized to be positive
			array( new DecimalValue( '+12' ),   '+11' ),
			array( new DecimalValue( '-12' ),   '-11' ),
			array( new DecimalValue( '+10' ),    '+9' ),
			array( new DecimalValue( '-10' ),    '-9' ),
			array( new DecimalValue('+100' ),   '+99' ),
			array( new DecimalValue('-100' ),   '-99' ),
			array( new DecimalValue(  '+0.02' ), '+0.01' ),
			array( new DecimalValue(  '-0.02' ), '-0.01' ),
			array( new DecimalValue(  '+0.10' ), '+0.09' ),
			array( new DecimalValue(  '-0.10' ), '-0.09' ),
		);
	}

	/**
	 * @dataProvider productProvider
	 */
	public function testProduct( DecimalValue $a, DecimalValue $b, $value ) {
		$math = new DecimalMath();

		$actual = $math->product( $a, $b );
		$this->assertEquals( $value, $actual->getValue() );

		$actual = $math->product( $b, $a );
		$this->assertEquals( $value, $actual->getValue() );
	}

	public function productProvider() {
		return array(
			array( new DecimalValue(  '+0'  ), new DecimalValue(  '+0'  ), '+0' ),
			array( new DecimalValue(  '+0'  ), new DecimalValue(  '+1'  ), '+0' ),
			array( new DecimalValue(  '+0'  ), new DecimalValue(  '+2'  ), '+0' ),

			array( new DecimalValue(  '+1'  ), new DecimalValue(  '+0'  ), '+0' ),
			array( new DecimalValue(  '+1'  ), new DecimalValue(  '+1'  ), '+1' ),
			array( new DecimalValue(  '+1'  ), new DecimalValue(  '+2'  ), '+2' ),

			array( new DecimalValue(  '+2'  ), new DecimalValue(  '+0'  ), '+0' ),
			array( new DecimalValue(  '+2'  ), new DecimalValue(  '+1'  ), '+2' ),
			array( new DecimalValue(  '+2'  ), new DecimalValue(  '+2'  ), '+4' ),

			array( new DecimalValue(  '+0.5'  ), new DecimalValue(  '+0'  ), '+0' ),
			array( new DecimalValue(  '+0.5'  ), new DecimalValue(  '+1'  ), '+0.5' ),
			array( new DecimalValue(  '+0.5'  ), new DecimalValue(  '+2'  ), '+1' ),
		);
	}

	/**
	 * @dataProvider sumProvider
	 */
	public function testSum( DecimalValue $a, DecimalValue $b, $value ) {
		$math = new DecimalMath();

		$actual = $math->sum( $a, $b );
		$this->assertEquals( $value, $actual->getValue() );

		$actual = $math->sum( $b, $a );
		$this->assertEquals( $value, $actual->getValue() );
	}

	public function sumProvider() {
		return array(
			array( new DecimalValue(  '+0'  ), new DecimalValue(  '+0'  ), '+0' ),
			array( new DecimalValue(  '+0'  ), new DecimalValue(  '+1'  ), '+1' ),
			array( new DecimalValue(  '+0'  ), new DecimalValue(  '+2'  ), '+2' ),

			array( new DecimalValue(  '+2'  ), new DecimalValue(  '+0'  ), '+2' ),
			array( new DecimalValue(  '+2'  ), new DecimalValue(  '+1'  ), '+3' ),
			array( new DecimalValue(  '+2'  ), new DecimalValue(  '+2'  ), '+4' ),

			array( new DecimalValue(  '+0.5'  ), new DecimalValue(  '+0'  ),  '+0.5' ),
			array( new DecimalValue(  '+0.5'  ), new DecimalValue(  '+0.5' ), '+1.0' ),
			array( new DecimalValue(  '+0.5'  ), new DecimalValue(  '+2'  ),  '+2.5' ),
		);
	}

	/**
	 * @dataProvider roundProvider
	 *
	 * @since 0.1
	 */
	public function testRound( DecimalValue $value, $digits, $expected ) {
		$math = new DecimalMath();

		$actual = $math->round( $value, $digits );
		$this->assertSame( $expected, $actual->getValue() );
	}

	public function roundProvider() {
		$argLists = array();

		//NOTE: Rounding is applied using the "round half away from zero" logic.

		$argLists[] = array( new DecimalValue( '+0' ), 1, '+0' );
		$argLists[] = array( new DecimalValue( '+0' ), 2, '+0' );
		$argLists[] = array( new DecimalValue( '+0.0' ), 1, '+0' );
		$argLists[] = array( new DecimalValue( '+0.0' ), 2, '+0' );
		$argLists[] = array( new DecimalValue( '+0.0' ), 3, '+0.0' );

		$argLists[] = array( new DecimalValue( '-2' ), 1, '-2' );
		$argLists[] = array( new DecimalValue( '-2' ), 2, '-2' );

		$argLists[] = array( new DecimalValue( '+23' ), 1, '+20' );
		$argLists[] = array( new DecimalValue( '+23' ), 2, '+23' );
		$argLists[] = array( new DecimalValue( '+23' ), 3, '+23' );

		$argLists[] = array( new DecimalValue( '-234' ), 1, '-200' );
		$argLists[] = array( new DecimalValue( '-234' ), 2, '-230' );
		$argLists[] = array( new DecimalValue( '-234' ), 3, '-234' );

		$argLists[] = array( new DecimalValue( '-2.0' ), 1, '-2' );
		$argLists[] = array( new DecimalValue( '-2.0' ), 2, '-2' );   // edge case, may change
		$argLists[] = array( new DecimalValue( '-2.0' ), 3, '-2.0' );
		$argLists[] = array( new DecimalValue( '-2.0' ), 4, '-2.0' ); // edge case, may change

		$argLists[] = array( new DecimalValue( '-2.000' ), 1, '-2' );
		$argLists[] = array( new DecimalValue( '-2.000' ), 2, '-2' );
		$argLists[] = array( new DecimalValue( '-2.000' ), 3, '-2.0' );
		$argLists[] = array( new DecimalValue( '-2.000' ), 4, '-2.00' );

		$argLists[] = array( new DecimalValue( '+2.5' ), 1, '+3' ); // rounded up
		$argLists[] = array( new DecimalValue( '+2.5' ), 2, '+3' );
		$argLists[] = array( new DecimalValue( '+2.5' ), 3, '+2.5' );
		$argLists[] = array( new DecimalValue( '+2.5' ), 4, '+2.5' );

		$argLists[] = array( new DecimalValue( '+2.05' ), 1, '+2' );
		$argLists[] = array( new DecimalValue( '+2.05' ), 2, '+2' );
		$argLists[] = array( new DecimalValue( '+2.05' ), 3, '+2.1' ); // rounded up
		$argLists[] = array( new DecimalValue( '+2.05' ), 4, '+2.05' );

		$argLists[] = array( new DecimalValue( '-23.05' ), 1, '-20' );
		$argLists[] = array( new DecimalValue( '-23.05' ), 2, '-23' );
		$argLists[] = array( new DecimalValue( '-23.05' ), 3, '-23' ); // edge case, may change
		$argLists[] = array( new DecimalValue( '-23.05' ), 4, '-23.1' ); // rounded down
		$argLists[] = array( new DecimalValue( '-23.05' ), 5, '-23.05' );

		$argLists[] = array( new DecimalValue( '+9.33' ), 1, '+9' ); // no rounding
		$argLists[] = array( new DecimalValue( '+9.87' ), 1, '+10' ); // rounding ripples up
		$argLists[] = array( new DecimalValue( '+9.87' ), 3, '+9.9' ); // rounding ripples up
		$argLists[] = array( new DecimalValue( '+99' ), 1, '+100' ); // rounding ripples up
		$argLists[] = array( new DecimalValue( '+99' ), 2, '+99' ); // rounding ripples up

		$argLists[] = array( new DecimalValue( '-9.33' ), 1, '-9' ); // no rounding
		$argLists[] = array( new DecimalValue( '-9.87' ), 1, '-10' ); // rounding ripples down
		$argLists[] = array( new DecimalValue( '-9.87' ), 3, '-9.9' ); // rounding ripples down
		$argLists[] = array( new DecimalValue( '-99' ), 1, '-100' ); // rounding ripples down
		$argLists[] = array( new DecimalValue( '-99' ), 2, '-99' ); // rounding ripples down

		return $argLists;
	}
}

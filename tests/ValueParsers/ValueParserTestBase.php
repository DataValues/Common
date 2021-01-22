<?php

declare( strict_types = 1 );

namespace ValueParsers\Tests;

use Comparable;
use DataValues\DataValue;
use PHPUnit\Framework\TestCase;
use ValueParsers\ParseException;
use ValueParsers\ValueParser;

/**
 * Base for unit tests for ValueParser implementing classes.
 *
 * @since 0.1
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ValueParserTestBase extends TestCase {

	/**
	 * @return array[]
	 */
	abstract public function validInputProvider();

	/**
	 * @return array[]
	 */
	abstract public function invalidInputProvider();

	/**
	 * @return ValueParser
	 */
	abstract protected function getInstance();

	/**
	 * @dataProvider validInputProvider
	 * @param mixed $value
	 * @param mixed $expected
	 * @param ValueParser|null $parser
	 */
	public function testParseWithValidInputs( $value, $expected, ValueParser $parser = null ) {
		if ( $parser === null ) {
			$parser = $this->getInstance();
		}

		$this->assertSmartEquals( $expected, $parser->parse( $value ) );
	}

	/**
	 * @param DataValue|mixed $expected
	 * @param DataValue|mixed $actual
	 */
	private function assertSmartEquals( $expected, $actual ) {
		if ( $this->requireDataValue() || $expected instanceof Comparable ) {
			if ( $expected instanceof DataValue && $actual instanceof DataValue ) {
				$msg = "testing equals():\n"
					. preg_replace( '/\s+/', ' ', print_r( $actual->toArray(), true ) ) . " should equal\n"
					. preg_replace( '/\s+/', ' ', print_r( $expected->toArray(), true ) );
			} else {
				$msg = 'testing equals()';
			}

			$this->assertTrue( $expected->equals( $actual ), $msg );
		} else {
			$this->assertEquals( $expected, $actual );
		}
	}

	/**
	 * @dataProvider invalidInputProvider
	 * @param mixed $value
	 * @param ValueParser|null $parser
	 */
	public function testParseWithInvalidInputs( $value, ValueParser $parser = null ) {
		if ( $parser === null ) {
			$parser = $this->getInstance();
		}

		$this->expectException( ParseException::class );
		$parser->parse( $value );
	}

	/**
	 * Returns if the result of the parsing process should be checked to be a DataValue.
	 *
	 * @return bool
	 */
	protected function requireDataValue() {
		return true;
	}

}

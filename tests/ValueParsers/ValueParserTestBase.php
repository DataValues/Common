<?php

namespace ValueParsers\Test;

use Comparable;
use DataValues\DataValue;
use ValueParsers\ParserOptions;
use ValueParsers\ValueParser;

/**
 * Base for unit tests for ValueParser implementing classes.
 *
 * @since 0.1
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ValueParserTestBase extends \PHPUnit_Framework_TestCase {

	/**
	 * @return string
	 */
	protected abstract function getParserClass();

	/**
	 * @return array[]
	 */
	public abstract function validInputProvider();

	/**
	 * @return array[]
	 */
	public function invalidInputProvider() {
		return array();
	}

	/**
	 * @return ValueParser
	 */
	protected function getInstance() {
		$class = $this->getParserClass();
		return new $class( $this->newParserOptions() );
	}

	/**
	 * @dataProvider validInputProvider
	 * @param mixed $value
	 * @param mixed $expected
	 * @param ValueParser|null $parser
	 */
	public function testParseWithValidInputs( $value, $expected, ValueParser $parser = null ) {
		if ( is_null( $parser ) ) {
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
		}
		else {
			$this->assertEquals( $expected, $actual );
		}
	}

	/**
	 * @dataProvider invalidInputProvider
	 * @param mixed $value
	 * @param ValueParser|null $parser
	 */
	public function testParseWithInvalidInputs( $value, ValueParser $parser = null ) {
		if ( is_null( $parser ) ) {
			$parser = $this->getInstance();
		}

		$this->setExpectedException( 'ValueParsers\ParseException' );

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

	/**
	 * Returns some parser options object with all required options for the parser under test set.
	 *
	 * @return ParserOptions
	 */
	protected function newParserOptions() {
		return new ParserOptions();
	}

}

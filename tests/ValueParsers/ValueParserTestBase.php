<?php

namespace ValueParsers\Test;

use DataValues\DataValue;
use ValueParsers\ParseException;
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
	 * @since 0.1
	 * @return string
	 */
	protected abstract function getParserClass();

	/**
	 * @since 0.1
	 */
	public abstract function validInputProvider();

	/**
	 * @since 0.1
	 */
	public function invalidInputProvider() {
		return array();
	}

	/**
	 * @since 0.1
	 * @return ValueParser
	 */
	protected function getInstance() {
		$class = $this->getParserClass();
		return new $class( $this->newParserOptions() );
	}

	/**
	 * @dataProvider validInputProvider
	 * @since 0.1
	 * @param $value
	 * @param mixed $expected
	 * @param ValueParser|null $parser
	 */
	public function testParseWithValidInputs( $value, $expected, ValueParser $parser = null ) {
		if ( is_null( $parser ) ) {
			$parser = $this->getInstance();
		}

		$this->assertSmartEquals( $expected, $parser->parse( $value ) );
	}

	private function assertSmartEquals( $expected, $actual ) {
		if ( $this->requireDataValue() || $expected instanceof \Comparable ) {
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
	 * @since 0.1
	 *
	 * @param $value
	 * @param ValueParser|null $parser
	 * @param string|null $cause expected cause
	 */
	public function testParseWithInvalidInputs( $value, ValueParser $parser = null, $cause = null ) {
		if ( is_null( $parser ) ) {
			$parser = $this->getInstance();
		}

		try {
			$parser->parse( $value );
			$this->fail( 'Failed to throw ParseException!' );
		} catch ( ParseException $ex ) {
			if ( $cause !== null ) {
				$this->assertInstanceOf( 'ValueParsers\LocalizableParseException', $ex );
				$this->assertEquals( $cause, $ex->getLocalizationCode(), 'error localization code' );
			}
		}
	}

	/**
	 * Returns if the result of the parsing process should be checked to be a DataValue.
	 *
	 * @since 0.1
	 *
	 * @return boolean
	 */
	protected function requireDataValue() {
		return true;
	}

	/**
	 * Returns some parser options object with all required options for the parser under test set.
	 *
	 * @since 0.1
	 *
	 * @return ParserOptions
	 */
	protected function newParserOptions() {
		return new ParserOptions();
	}

}

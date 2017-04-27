<?php

namespace ValueParsers\Test;

use DataValues\BooleanValue;
use ValueParsers\BoolParser;

/**
 * @covers ValueParsers\BoolParser
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class BoolParserTest extends StringValueParserTest {

	/**
	 * @see ValueParserTestBase::getInstance
	 *
	 * @return BoolParser
	 */
	protected function getInstance() {
		return new BoolParser();
	}

	/**
	 * @see ValueParserTestBase::validInputProvider
	 */
	public function validInputProvider() {
		$argLists = [];

		$valid = [
			'yes' => true,
			'on' => true,
			'1' => true,
			'true' => true,
			'no' => false,
			'off' => false,
			'0' => false,
			'false' => false,

			'YeS' => true,
			'ON' => true,
			'No' => false,
			'OfF' => false,
		];

		foreach ( $valid as $value => $expected ) {
			$expected = new BooleanValue( $expected );
			$argLists[] = [ (string)$value, $expected ];
		}

		return $argLists;
	}

	/**
	 * @see StringValueParserTest::invalidInputProvider
	 */
	public function invalidInputProvider() {
		$argLists = parent::invalidInputProvider();

		$invalid = [
			'foo',
			'2',
		];

		foreach ( $invalid as $value ) {
			$argLists[] = [ $value ];
		}

		return $argLists;
	}

}

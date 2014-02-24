<?php

namespace ValueFormatters\Test;

use DataValues\StringValue;

/**
 * Unit tests for the ValueFormatters\StringFormatter class.
 *
 * @since 0.1
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class StringFormatterTest extends ValueFormatterTestBase {

	/**
	 * @see ValueFormatterTestBase::validProvider
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public function validProvider() {
		$strings = array(
			'ice cream' => 'ice cream',
			'cake' => 'cake',
			'' => '',
			' a ' => 'a',
			' a' => 'a',
			'a ' => 'a',
			'         ' => '',
			' ' => '',
		);

		$argLists = array();

		foreach ( $strings as $value => $expected ) {
			$argLists[] = array( new StringValue( $value ), $expected );
		}

		return $argLists;
	}

	/**
	 * @see ValueFormatterTestBase::getFormatterClass
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected function getFormatterClass() {
		return 'ValueFormatters\StringFormatter';
	}

}

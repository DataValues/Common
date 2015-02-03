<?php

namespace ValueFormatters\Test;

use DataValues\StringValue;

/**
 * @covers ValueFormatters\StringFormatter
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class StringFormatterTest extends ValueFormatterTestBase {

	/**
	 * @see ValueFormatterTestBase::getFormatterClass
	 *
	 * @return string
	 */
	protected function getFormatterClass() {
		return 'ValueFormatters\StringFormatter';
	}

	/**
	 * @see ValueFormatterTestBase::validProvider
	 */
	public function validProvider() {
		$strings = array(
			'ice cream',
			'cake',
			'',
			' a ',
			'  ',
		);

		$argLists = array();

		foreach ( $strings as $string ) {
			$argLists[] = array( new StringValue( $string ), $string );
		}

		return $argLists;
	}

}

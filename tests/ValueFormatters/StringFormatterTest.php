<?php

namespace ValueFormatters\Test;

use DataValues\StringValue;
use ValueFormatters\FormatterOptions;
use ValueFormatters\StringFormatter;

/**
 * @covers ValueFormatters\StringFormatter
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class StringFormatterTest extends ValueFormatterTestBase {

	/**
	 * @deprecated since DataValues Interfaces 0.2, just use getInstance.
	 */
	protected function getFormatterClass() {
		throw new \LogicException( 'Should not be called, use getInstance' );
	}

	/**
	 * @see ValueFormatterTestBase::getInstance
	 *
	 * @param FormatterOptions|null $options
	 *
	 * @return StringFormatter
	 */
	protected function getInstance( FormatterOptions $options = null ) {
		return new StringFormatter( $options );
	}

	/**
	 * @see ValueFormatterTestBase::validProvider
	 */
	public function validProvider() {
		return [
			[ new StringValue( 'ice cream' ), 'ice cream' ],
			[ new StringValue( 'cake' ), 'cake' ],
			[ new StringValue( '' ), '' ],
			[ new StringValue( ' a ' ), ' a ' ],
			[ new StringValue( '  ' ), '  ' ],
		];
	}

	/**
	 * @dataProvider invalidProvider
	 */
	public function testInvalidFormat( $value ) {
		$formatter = new StringFormatter();
		$this->setExpectedException( 'InvalidArgumentException' );
		$formatter->format( $value );
	}

	public function invalidProvider() {
		return [
			[ null ],
			[ 0 ],
			[ '' ],
		];
	}

}

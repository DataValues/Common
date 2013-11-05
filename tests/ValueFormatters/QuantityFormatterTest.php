<?php

namespace ValueFormatters\Test;

use DataValues\QuantityValue;
use ValueFormatters\DecimalFormatter;
use ValueFormatters\QuantityFormatter;
use ValueFormatters\FormatterOptions;
use ValueFormatters\ValueFormatter;
use Wikibase\Lib\Serializers\SerializationOptions;

/**
 * @covers ValueFormatters\QuantityFormatter
 *
 * @since 0.1
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class QuantityFormatterTest extends ValueFormatterTestBase {

	/**
	 * @see ValueFormatterTestBase::validProvider
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public function validProvider() {
		$noMargin = new FormatterOptions( array( QuantityFormatter::OPT_SHOW_UNCERTAINTY_MARGIN => false ) );
		$withMargin = new FormatterOptions( array( QuantityFormatter::OPT_SHOW_UNCERTAINTY_MARGIN => true ) );

		return array(
			array( QuantityValue::newFromNumber( '+0', '1', '+0', '+0' ), '0', $noMargin ),
			array( QuantityValue::newFromNumber( '+0', '1', '+0', '+0' ), '0', $withMargin ),
			array( QuantityValue::newFromNumber( '+0.0', '°', '+0.1', '-0.1' ), '0.0°', $noMargin ),
			array( QuantityValue::newFromNumber( '+0.0', '°', '+0.1', '-0.1' ), '0.0±0.1°', $withMargin ),
			array( QuantityValue::newFromNumber( '-1205', 'm', '-1105', '-1305' ), '-1200m', $noMargin ),
			array( QuantityValue::newFromNumber( '-1205', 'm', '-1105', '-1305' ), '-1200±100m', $withMargin ),
			array( QuantityValue::newFromNumber( '+3.025', '1', '+3.02744', '+3.0211' ), '3.025', $noMargin ),
			array( QuantityValue::newFromNumber( '+3.025', '1', '+3.02744', '+3.0211' ), '3.025±0.004', $withMargin ),
		);
	}

	/**
	 * @see ValueFormatterTestBase::getFormatterClass
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected function getFormatterClass() {
		return 'ValueFormatters\QuantityFormatter';
	}

	/**
	 * @see ValueFormatterTestBase::getInstance
	 *
	 * @param FormatterOptions $options
	 *
	 * @return ValueFormatter
	 */
	protected function getInstance( FormatterOptions $options ) {
		$decimalFormatter = new DecimalFormatter( $options );
		$class = $this->getFormatterClass();
		return new $class( $decimalFormatter, $options );
	}
}

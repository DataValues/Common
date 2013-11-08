<?php

namespace ValueFormatters;

use DataValues\DecimalMath;
use DataValues\QuantityValue;
use InvalidArgumentException;

/**
 * Formatter for quantity values
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class QuantityFormatter extends ValueFormatterBase {

	const OPT_SHOW_UNCERTAINTY_MARGIN = 'showQuantityUncertaintyMargin';

	/**
	 * @var DecimalMath
	 */
	protected $decimalMath;

	/**
	 * @var DecimalMath
	 */
	protected $decimalFormatter;

	/**
	 * @param DecimalFormatter $decimalFormatter
	 * @param FormatterOptions $options
	 */
	public function __construct( DecimalFormatter $decimalFormatter, FormatterOptions $options ) {
		parent::__construct( $options );

		$this->decimalFormatter = $decimalFormatter;

		// plain composition should be sufficient
		$this->decimalMath = new DecimalMath();
	}


	/**
	 * Formats a QuantityValue data value
	 *
	 * @since 0.1
	 *
	 * @param mixed $dataValue value to format
	 *
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public function format( $dataValue ) {
		if ( !( $dataValue instanceof QuantityValue ) ) {
			throw new InvalidArgumentException( 'DataValue is not a QuantityValue.' );
		}

		$roundingExponent = $dataValue->getOrderOfUncertainty();

		$amountValue = $dataValue->getAmount();
		$amountValue = $this->decimalMath->roundToExponent( $amountValue, $roundingExponent );
		$amount = $this->decimalFormatter->format( $amountValue );

		$unit = $dataValue->getUnit();

		$margin = '';

		if ( !$this->options->hasOption( self::OPT_SHOW_UNCERTAINTY_MARGIN )
			|| $this->options->getOption( self::OPT_SHOW_UNCERTAINTY_MARGIN ) == true ) {

			$marginValue = $dataValue->getUncertaintyMargin();
			$marginValue = $this->decimalMath->roundToExponent( $marginValue, $roundingExponent );

			if ( !$marginValue->isZero() ) {
				$margin = $this->decimalFormatter->format( $marginValue );
			}
		}

		//TODO: use localizable pattern for constructing the output.
		$quantity = $amount;

		if ( $margin !== '' ) {
			$quantity .= '±' . $margin;
		}

		if ( $unit !== '1' ) {
			//XXX: do we need to localize unit names?
			$quantity .= $unit;
		}

		return $quantity;
	}

}

<?php

namespace ValueFormatters;

use DataValues\QuantityValue;
use InvalidArgumentException;

/**
 * Formatter for quantity values
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author H. Snater < mediawiki@snater.com >
 */
class QuantityFormatter extends ValueFormatterBase {

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

		// TODO: Implement proper formatting mechanics
		return $dataValue->getValue()->getAmount()->getValue();
	}

}

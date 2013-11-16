<?php

namespace ValueFormatters;

use DataValues\IriValue;
use InvalidArgumentException;

/**
 * Formatter for string values
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class IriFormatter extends ValueFormatterBase {

	/**
	 * Formats a StringValue data value
	 *
	 * @since 0.1
	 *
	 * @param mixed $dataValue value to format
	 *
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public function format( $dataValue ) {
		if ( !( $dataValue instanceof IriValue ) ) {
			throw new InvalidArgumentException( 'DataValue is not a IriValue.' );
		}

		$formatted = $dataValue->getScheme() . ':'
			. $dataValue->getHierarchicalPart()
			. ( $dataValue->getQuery() === '' ? '' : '?' . $dataValue->getQuery() )
			. ( $dataValue->getFragment() === '' ? '' : '#' . $dataValue->getFragment() );

		return $formatted;
	}

}

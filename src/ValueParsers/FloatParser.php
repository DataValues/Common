<?php

declare( strict_types = 1 );

namespace ValueParsers;

use DataValues\NumberValue;

/**
 * ValueParser that parses the string representation of a float.
 *
 * @since 0.1
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FloatParser extends StringValueParser {

	private const FORMAT_NAME = 'float';

	/**
	 * @see StringValueParser::stringParse
	 *
	 * TODO: add options for different group and decimal separators.
	 *
	 * @param string $value
	 *
	 * @return NumberValue
	 * @throws ParseException
	 */
	protected function stringParse( $value ) {
		if ( preg_match( '/^(-)?\d+((\.|,)\d+)?$/', $value ) ) {
			return new NumberValue( (float)$value );
		}

		throw new ParseException( 'Not a float', $value, self::FORMAT_NAME );
	}

}

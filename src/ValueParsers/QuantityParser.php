<?php

namespace ValueParsers;

use DataValues\DecimalValue;
use DataValues\IllegalValueException;
use DataValues\QuantityValue;

/**
 * ValueParser that parses the string representation of a QuantityValue.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author H. Snater < mediawiki@snater.com >
 */
class QuantityParser implements ValueParser {
	/**
	 * @see ValueParser::parse
	 *
	 * @since 0.1
	 *
	 * @param mixed $value
	 *
	 * @return mixed
	 * @throws ParseException
	 */
	public function parse( $value ) {
		// TODO: Implement proper parser
		try {
			$amount = new DecimalValue( $value );
			return new QuantityValue( $amount, '1', $amount, $amount );

		} catch( ParseException $e ) {
			throw new ParseException( 'Not a quantity' );
		} catch( IllegalValueException $e ) {
			throw new ParseException( 'Not a quantity' );
		}
	}
}

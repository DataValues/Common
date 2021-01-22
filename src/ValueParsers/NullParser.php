<?php

declare( strict_types = 1 );

namespace ValueParsers;

use DataValues\UnknownValue;

/**
 * Implementation of the ValueParser interface that does a null parse.
 *
 * @since 0.1
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class NullParser implements ValueParser {

	/**
	 * @see ValueParser::parse
	 *
	 * @param mixed $value
	 *
	 * @return UnknownValue
	 */
	public function parse( $value ) {
		return new UnknownValue( $value );
	}

}

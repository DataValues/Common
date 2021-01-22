<?php

declare( strict_types = 1 );

namespace ValueFormatters;

use DataValues\StringValue;
use InvalidArgumentException;

/**
 * Trivial formatter for StringValue objects that does nothing but returning the string value as it
 * is.
 *
 * @since 0.1
 *
 * @license GPL-2.0-or-later
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class StringFormatter implements ValueFormatter {

	/**
	 * @see ValueFormatter::format
	 *
	 * @param StringValue $dataValue
	 *
	 * @throws InvalidArgumentException
	 * @return string Text
	 */
	public function format( $dataValue ) {
		if ( !( $dataValue instanceof StringValue ) ) {
			throw new InvalidArgumentException( 'Data value type mismatch. Expected a StringValue.' );
		}

		return $dataValue->getValue();
	}

}

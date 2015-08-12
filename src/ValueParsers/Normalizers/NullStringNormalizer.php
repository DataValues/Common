<?php

namespace ValueParsers\Normalizers;

use InvalidArgumentException;

/**
 * Null implementation of StringNormalizer.
 *
 * @since 1.0
 *
 * @license GPL 2+
 * @author Daniel Kinzler
 */
class NullStringNormalizer implements StringNormalizer {

	/**
	 * @param string $value
	 *
	 * @throws InvalidArgumentException if $value is not a string
	 * @return string the normalized value
	 */
	public function normalize( $value ) {
		if ( !is_string( $value ) ) {
			throw new InvalidArgumentException( 'Parameter $value must be a string' );
		}

		return $value;
	}

}

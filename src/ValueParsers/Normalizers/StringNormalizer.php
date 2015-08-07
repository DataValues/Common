<?php

namespace ValueParsers\Normalizers;

use InvalidArgumentException;

/**
 * Interface for string normalization
 *
 * @license GPL 2+
 * @author Daniel Kinzler
 */
interface StringNormalizer {

	/**
	 * @param string $value the value to normalize
	 *
	 * @return string the normalized value
	 *
	 * @throws InvalidArgumentException if $value is not a string
	 */
	public function normalize( $value );

}

<?php

namespace ValueParsers;

use InvalidArgumentException;
use DataValues\StringValue;
use ValueParsers\Normalizers\NullStringNormalizer;
use ValueParsers\Normalizers\StringNormalizer;

/**
 * Implementation of the ValueParser interface for StringValues.
 *
 * @since 0.2.4
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class StringParser implements ValueParser {

	/**
	 * @var StringNormalizer
	 */
	private $normalizer;

	/**
	 * @param StringNormalizer $normalizer
	 */
	public function __construct( StringNormalizer $normalizer = null ) {
		if ( $normalizer === null ) {
			$normalizer = new NullStringNormalizer();
		}

		$this->normalizer = $normalizer;
	}

	/**
	 * @see ValueParser::parse
	 *
	 * @param string $value
	 *
	 * @return StringValue
	 *
	 * @throws InvalidArgumentException if $value is not a string
	 */
	public function parse( $value ) {
		if ( !is_string( $value ) ) {
			throw new InvalidArgumentException( 'Parameter $value must be a string' );
		}

		$value = $this->normalizer->normalize( $value );
		return new StringValue( $value );
	}

}

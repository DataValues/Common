<?php

declare( strict_types = 1 );

namespace ValueParsers;

use DataValues\StringValue;
use ValueParsers\Normalizers\NullStringNormalizer;
use ValueParsers\Normalizers\StringNormalizer;

/**
 * Implementation of the ValueParser interface for StringValues.
 *
 * @since 0.3
 *
 * @license GPL-2.0-or-later
 * @author Daniel Kinzler
 */
class StringParser implements ValueParser {

	/**
	 * @var StringNormalizer
	 */
	private $normalizer;

	/**
	 * @param StringNormalizer|null $normalizer
	 */
	public function __construct( StringNormalizer $normalizer = null ) {
		$this->normalizer = $normalizer ?: new NullStringNormalizer();
	}

	/**
	 * @see ValueParser::parse
	 *
	 * @param string $value
	 *
	 * @throws ParseException if the provided value is not a string
	 * @return StringValue
	 */
	public function parse( $value ) {
		if ( !is_string( $value ) ) {
			throw new ParseException( 'Parameter $value must be a string' );
		}

		$value = $this->normalizer->normalize( $value );
		return new StringValue( $value );
	}

}

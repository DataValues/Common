<?php

declare( strict_types = 1 );

namespace ValueParsers;

use InvalidArgumentException;
use RuntimeException;

/**
 * Basic implementation for DataValue parsers that share one or more of the following aspects:
 * - The provided input must be a string.
 * - The parser utilizes ParserOptions.
 * - The parser utilizes a "lang" option, which defaults to "en".
 *
 * @since 0.1
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class StringValueParser implements ValueParser {

	/**
	 * @var ParserOptions
	 */
	protected $options;

	/**
	 * @param ParserOptions|null $options
	 */
	public function __construct( ParserOptions $options = null ) {
		$this->options = $options ?: new ParserOptions();

		$this->defaultOption( ValueParser::OPT_LANG, 'en' );
	}

	/**
	 * @see ValueParser::parse
	 *
	 * @param string $value
	 *
	 * @return mixed
	 * @throws ParseException if the provided value is not a string
	 */
	public function parse( $value ) {
		if ( is_string( $value ) ) {
			return $this->stringParse( $value );
		}

		throw new ParseException( 'Not a string' );
	}

	/**
	 * Parses the provided string and returns the result.
	 *
	 * @param string $value
	 *
	 * @return mixed
	 */
	abstract protected function stringParse( $value );

	public function setOptions( ParserOptions $options ) {
		$this->options = $options;
	}

	/**
	 * @return ParserOptions
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * Shortcut to $this->options->getOption.
	 *
	 * @param string $option
	 *
	 * @throws InvalidArgumentException
	 * @return mixed
	 */
	final protected function getOption( $option ) {
		return $this->options->getOption( $option );
	}

	/**
	 * Shortcut to $this->options->requireOption.
	 *
	 * @param string $option
	 *
	 * @throws RuntimeException
	 */
	final protected function requireOption( $option ) {
		$this->options->requireOption( $option );
	}

	/**
	 * Shortcut to $this->options->defaultOption.
	 *
	 * @param string $option
	 * @param mixed $default
	 */
	final protected function defaultOption( $option, $default ) {
		$this->options->defaultOption( $option, $default );
	}

}

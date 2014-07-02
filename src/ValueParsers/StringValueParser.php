<?php

namespace ValueParsers;

use RuntimeException;

/**
 * ValueParser that parses the string representation of something.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
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
		if ( $options === null ) {
			$options = new ParserOptions();
		}

		$this->options = $options;

		$this->defaultOption( ValueParser::OPT_LANG, 'en' );
	}

	/**
	 * @see ValueParser::parse
	 *
	 * @param mixed $value
	 *
	 * @return mixed
	 * @throws ParseException
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
	protected abstract function stringParse( $value );

	/**
	 * @see ValueParser::setOptions
	 *
	 * @param ParserOptions $options
	 */
	public function setOptions( ParserOptions $options ) {
		$this->options = $options;
	}

	/**
	 * @see ValueParser::getOptions
	 *
	 * @return ParserOptions
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * Shortcut to $this->options->getOption.
	 *
	 * @param string $option
	 */
	protected final function getOption( $option ) {
		return $this->options->getOption( $option );
	}

	/**
	 * Shortcut to $this->options->requireOption.
	 *
	 * @param string $option
	 *
	 * @throws RuntimeException
	 */
	protected final function requireOption( $option ) {
		$this->options->requireOption( $option );
	}

	/**
	 * Shortcut to $this->options->defaultOption.
	 *
	 * @param string $option
	 * @param mixed $default
	 */
	protected final function defaultOption( $option, $default ) {
		$this->options->defaultOption( $option, $default );
	}

}

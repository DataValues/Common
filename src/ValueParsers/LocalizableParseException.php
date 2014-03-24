<?php

namespace ValueParsers;

use Exception;
use InvalidArgumentException;

/**
 * A Parse exception that supports localized messages.
 *
 * @since 0.2.2
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class LocalizableParseException extends ParseException {

	/**
	 * @var string|null
	 */
	private $localizationCode = null;

	/**
	 * @var string[]
	 */
	private $localizationParameters = array();

	/**
	 * @param string $message A plain text message describing the exception (in english).
	 * @param string $localizationCode A string identifying the localizationCode of the exception.
	 *        May be used to construct a localization key.
	 *        Not to be confused with the $code parameter in the constructor of Exception.
	 * @param string[] $localizationParameters A list of strings providing additional information about
	 *        the localizationCode of the exception.
	 * @param Exception $previous For exception chaining.
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( $message = '', $localizationCode = '', array $localizationParameters = array(), Exception $previous = null ) {
		parent::__construct( $message, 0, $previous );

		if ( !is_string( $localizationCode ) ) {
			throw new InvalidArgumentException( '$localizationCode must be a string' );
		}

		foreach ( $localizationParameters as $key => $value ) {
			if ( !is_int( $key ) ) {
				throw new InvalidArgumentException( '$localizationParameters must be an indexed array of positional parameters' );
			}

			if ( !is_string( $value ) ) {
				throw new InvalidArgumentException( '$localizationParameters must contain string values only' );
			}
		}

		$this->localizationCode = $localizationCode;
		$this->localizationParameters = $localizationParameters;
	}

	/**
	 * Returns a code identifying the localizationCode of the localizationCode of the exception, or null
	 * if the localizationCode was not set using setLocalizationCode().
	 *
	 * @note Not to be confused with getCode().
	 *
	 * @see getLocalizationParameter()
	 *
	 * @return string|null
	 */
	public function getLocalizationCode() {
		return $this->localizationCode;
	}

	/**
	 * Returns any parameters associated with the localizationCode of the exception, as
	 * provided to setLocalizationCode().
	 *
	 * @see getLocalizationCode()
	 *
	 * @return string[]
	 */
	public function getLocalizationParameters() {
		return $this->localizationParameters;
	}

}

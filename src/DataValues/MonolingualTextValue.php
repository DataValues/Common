<?php

declare( strict_types = 1 );

namespace DataValues;

/**
 * Class representing a monolingual text value.
 *
 * @since 0.1
 *
 * @license GPL-2.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MonolingualTextValue extends DataValueObject {

	/**
	 * @var string
	 */
	private $languageCode;

	/**
	 * @var string
	 */
	private $text;

	/**
	 * @param string $languageCode
	 * @param string $text
	 *
	 * @throws IllegalValueException
	 */
	public function __construct( $languageCode, $text ) {
		if ( !is_string( $languageCode ) || $languageCode === '' ) {
			throw new IllegalValueException( '$languageCode must be a non-empty string' );
		}
		if ( !is_string( $text ) ) {
			throw new IllegalValueException( '$text must be a string' );
		}

		$this->languageCode = $languageCode;
		$this->text = $text;
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @return string
	 */
	public function serialize() {
		return serialize( $this->__serialize() );
	}

	public function __serialize(): array {
		return [ $this->languageCode, $this->text ];
	}

	/**
	 * @see Serializable::unserialize
	 *
	 * @param string $value
	 */
	public function unserialize( $value ) {
		$this->__unserialize( unserialize( $value ) );
	}

	public function __unserialize( array $data ): void {
		list( $languageCode, $text ) = $data;
		$this->__construct( $languageCode, $text );
	}

	/**
	 * @see DataValue::getType
	 *
	 * @return string
	 */
	public static function getType() {
		return 'monolingualtext';
	}

	/**
	 * @deprecated Kept for compatibility with older DataValues versions.
	 * Do not use.
	 *
	 * @return string
	 */
	public function getSortKey() {
		// TODO: we might want to re-think this key. Perhaps the language should simply be omitted.
		return $this->languageCode . $this->text;
	}

	/**
	 * @see DataValue::getValue
	 *
	 * @return self
	 */
	public function getValue() {
		return $this;
	}

	/**
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * @return string
	 */
	public function getLanguageCode() {
		return $this->languageCode;
	}

	/**
	 * @see DataValue::getArrayValue
	 *
	 * @return string[]
	 */
	public function getArrayValue() {
		return [
			'text' => $this->text,
			'language' => $this->languageCode,
		];
	}

	/**
	 * Constructs a new instance from the provided data. Required for @see DataValueDeserializer.
	 * This is expected to round-trip with @see getArrayValue.
	 *
	 * @deprecated since 1.0.0. Static DataValue::newFromArray constructors like this are
	 *  underspecified (not in the DataValue interface), and misleadingly named (should be named
	 *  newFromArrayValue). Instead, use DataValue builder callbacks in @see DataValueDeserializer.
	 *
	 * @param mixed $data Warning! Even if this is expected to be a value as returned by
	 *  @see getArrayValue, callers of this specific newFromArray implementation can not guarantee
	 *  this. This is not even guaranteed to be an array!
	 *
	 * @throws IllegalValueException if $data is not in the expected format. Subclasses of
	 *  InvalidArgumentException are expected and properly handled by @see DataValueDeserializer.
	 * @return self
	 */
	public static function newFromArray( $data ) {
		self::requireArrayFields( $data, [ 'language', 'text' ] );

		return new static( $data['language'], $data['text'] );
	}

}

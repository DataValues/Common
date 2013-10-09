<?php

namespace DataValues;

/**
 * Class representing a decimal number with (nearly) arbitrary precision.
 *
 * For simple numeric values use @see NumberValue.
 *
 * The decimal notation for the value follows ISO 31-0, with some additional restrictions:
 * - the decimal separator is '.' (period). Comma is not used anywhere.
 * - no spacing or other separators are included for groups of digits.
 * - the first character in the string always gives the sign, either plus (+) or minus (-).
 * - scientific (exponential) notation is not used.
 * - the decimal point must not be the last character nor the fist character after the sign.
 * - no leading zeros, except one directly before the decimal point
 * - zero is always positive.
 *
 * These rules are enforced by @see QUANTITY_VALUE_PATTERN
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class DecimalValue extends DataValueObject {

	/**
	 * The $value as a decimal string, in the format described in the class
	 * level documentation of @see DecimalValue, matching @see QUANTITY_VALUE_PATTERN.
	 *
	 * @since 0.1
	 *
	 * @var string
	 */
	protected $value;

	/**
	 * Regular expression for matching decimal strings that conform to the format
	 * described in the class level documentation of @see DecimalValue.
	 */
	const QUANTITY_VALUE_PATTERN = '/^[-+]([1-9][0-9]*|[0-9])(\.[0-9]+)?$/';

	/**
	 * Constructs a new DecimalValue object, representing the given value.
	 *
	 * @param string|int|float $value If given as a string, the value must match
	 *                         QUANTITY_VALUE_PATTERN.
	 */
	public function __construct( $value ) {
		if ( is_int( $value ) || is_float( $value ) ) {
			$value = self::convertToDecimal( $value );
		}

		self::assertNumberString( $value, '$value' );

		// make "negative" zero positive
		$value = preg_replace( '/^-(0+(\.0+)?)$/', '+\1', $value );

		$this->value = $value;
	}

	/**
	 * Checks that the given value is a number string.
	 *
	 * @param string $number The value to check
	 * @param string $name  The name to use in error messages
	 *
	 * @throws IllegalValueException
	 */
	protected static function assertNumberString( $number, $name ) {
		if ( !is_string( $number ) ) {
			throw new IllegalValueException( $name . ' must be a numeric string' );
		}

		if ( !preg_match( self::QUANTITY_VALUE_PATTERN, $number ) ) {
			throw new IllegalValueException( $name . ' must match the pattern for numeric values: bad value: `' . $number . '`' );
		}

		if ( strlen( $number ) > 127 ) {
			throw new IllegalValueException( $name . ' must be at most 127 characters long.' );
		}
	}

	/**
	 * Converts the given number to decimal notation. The resulting string conforms to the
	 * rules described in the class level documentation of @see DecimalValue and matches
	 * @see DecimalValue::QUANTITY_VALUE_PATTERN.
	 *
	 * @param int|float $number
	 *
	 * @return string
	 * @throws \InvalidArgumentException
	 */
	protected static function convertToDecimal( $number ) {
		if ( !is_int( $number ) && !is_float( $number ) ) {
			throw new \InvalidArgumentException( '$number must be an int or float' );
		}

		if ( $number === NAN || abs( $number ) === INF ) {
			throw new \InvalidArgumentException( '$number must not be NAN or INF' );
		}

		if ( is_int( $number ) ) {
			$decimal = strval( abs( $number ) );
		} else {
			$decimal = trim( number_format( abs( $number ), 100, '.', '' ), 0 );

			if ( $decimal[0] === '.' ) {
				$decimal = '0' . $decimal;
			}

			$last = strlen($decimal)-1;

			if ( $decimal[$last] === '.' ) {
				$decimal = $decimal . '0';
			}
		}

		$decimal = ( ( $number >= 0.0 ) ? '+' : '-' ) . $decimal;

		self::assertNumberString( $decimal, '$number' );
		return $decimal;
	}

	/**
	 * Compares this DecimalValue to another DecimalValue.
	 *
	 * @since 0.1
	 *
	 * @param DecimalValue $that
	 *
	 * @throws \LogicException
	 * @return int +1 if $this > $that, 0 if $this == $that, -1 if $this < $that
	 */
	public function compare( DecimalValue $that ) {
		if ( $this === $that ) {
			return 0;
		}

		$a = $this->getValue();
		$b = $that->getValue();

		if ( $a === $b ) {
			return 0;
		}

		if ( $a[0] === '+' && $b[0] === '-' ) {
			return 1;
		}

		if ( $a[0] === '-' && $b[0] === '+' ) {
			return -1;
		}

		// compare the integer parts
		$aIntDigits =  strpos( $a, '.' );
		$bIntDigits =  strpos( $b, '.' );
		$aInt = ltrim( substr( $a, 1, ( $aIntDigits ? $aIntDigits : strlen( $a ) ) -1 ), '0' );
		$bInt = ltrim( substr( $b, 1, ( $bIntDigits ? $bIntDigits : strlen( $b ) ) -1 ), '0' );

		$sense = $a[0] === '+' ? 1 : -1;

		// per precondition, there are no leading zeros, so the longer nummber is greater
		if ( strlen( $aInt ) > strlen( $bInt ) ) {
			return $sense;
		}

		if ( strlen( $aInt ) < strlen( $bInt ) ) {
			return -$sense;
		}

		// if both have equal length, compare alphanumerically
		if ( $aInt > $bInt ) {
			return $sense;
		}

		if ( $aInt < $bInt ) {
			return -$sense;
		}

		// compare fractional parts
		$aFract = rtrim( substr( $a, $aIntDigits +1 ), '0' );
		$bFract = rtrim( substr( $b, $bIntDigits +1 ), '0' );

		// the fractional part is left-aligned, so just check alphanumeric ordering
		$cmp = strcmp( $aFract, $bFract );
		return  ( $cmp > 0 ? 1 : ( $cmp < 0 ? -1 : 0 ) );
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function serialize() {
		return serialize( $this->value );
	}

	/**
	 * @see Serializable::unserialize
	 *
	 * @since 0.1
	 *
	 * @param string $data
	 *
	 * @return DecimalValue
	 */
	public function unserialize( $data ) {
		$value = unserialize( $data );
		$this->__construct( $value );
	}

	/**
	 * @see DataValue::getType
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public static function getType() {
		return 'decimal';
	}

	/**
	 * @see DataValue::getSortKey
	 *
	 * @since 0.1
	 *
	 * @return float
	 */
	public function getSortKey() {
		return $this->getValueFloat();
	}

	/**
	 * Returns the value as a decimal string, using the format described in the class level
	 * documentation of @see DecimalValue and matching @see DecimalValue::QUANTITY_VALUE_PATTERN.
	 * In particular, the string always starts with a sign (either '+' or '-')
	 * and has no leading zeros (except immediately before the decimal point). The decimal point is
	 * optional, but must not be the last character. Trailing zeros are significant.
	 *
	 * @see DataValue::getValue
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Returns the sign of the amount (+ or -).
	 *
	 * @since 0.1
	 *
	 * @return string "+" or "-".
	 */
	public function getSign() {
		return substr( $this->value, 0, 1 );
	}

	/**
	 * Returns the value held by this object, as a float.
	 * Equivalent to floatval( $this->getvalue() ).
	 *
	 * @since 0.1
	 *
	 * @return float
	 */
	public function getValueFloat() {
		return floatval( $this->getValue() );
	}

	/**
	 * @see DataValue::getArrayValue
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getArrayValue() {
		return $this->value;
	}

	/**
	 * Constructs a new instance of the DataValue from the provided data.
	 * This can round-trip with @see getArrayValue
	 *
	 * @since 0.1
	 *
	 * @param string $data
	 *
	 * @return DecimalValue
	 * @throws IllegalValueException
	 */
	public static function newFromArray( $data ) {
		return new static( $data );
	}

	/**
	 * @since 0.1
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->value;
	}
}

<?php

namespace DataValues;

use LogicException;

/**
 * Class representing a quantity with associated unit and uncertainty interval.
 * The amount is stored as a @see DecimalValue object.
 *
 * For simple numeric amounts use @see NumberValue.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class QuantityValue extends DataValueObject {

	/**
	 * The quantity's amount
	 *
	 * @var DecimalValue
	 */
	protected $amount;

	/**
	 * The quantity's unit identifier (use "1" for unitless quantities).
	 *
	 * @var string
	 */
	protected $unit;

	/**
	 * The quantity's upper bound
	 *
	 * @var DecimalValue
	 */
	protected $upperBound;

	/**
	 * The quantity's lower bound
	 *
	 * @var DecimalValue
	 */
	protected $lowerBound;

	/**
	 * Constructs a new QuantityValue object, representing the given value.
	 *
	 * @since 0.1
	 *
	 * @param DecimalValue $amount
	 * @param string $unit A unit identifier. Must not be empty, use "1" for unit-less quantities.
	 * @param DecimalValue $upperBound The upper bound of the quantity, inclusive.
	 * @param DecimalValue $lowerBound The lower bound of the quantity, inclusive.
	 *
	 * @throws IllegalValueException
	 */
	public function __construct( DecimalValue $amount, $unit, DecimalValue $upperBound, DecimalValue $lowerBound ) {
		if ( $lowerBound->compare( $amount ) > 0 ) {
			throw new IllegalValueException( '$lowerBound must be <= $amount' );
		}

		if ( $upperBound->compare( $amount ) < 0 ) {
			throw new IllegalValueException( '$upperBound must be >= $amount' );
		}

		if ( !is_string( $unit ) ) {
			throw new IllegalValueException( '$unit needs to be a string' );
		}

		if ( $unit === '' ) {
			throw new IllegalValueException( '$unit can not be an empty string (use "1" for unit-less quantities)' );
		}

		$this->amount = $amount;
		$this->unit = $unit;
		$this->upperBound = $upperBound;
		$this->lowerBound = $lowerBound;
	}

	/**
	 * Returns a QuantityValue representing the given amount.
	 * If no upper or lower bound is given, the amount is assumed to be exact.
	 *
	 * @since 0.1
	 *
	 * @param int|float $amount
	 * @param string $unit
	 * @param int|float|null $upperBound
	 * @param int|float|null $lowerBound
	 *
	 * @return QuantityValue
	 * @throws IllegalValueException
	 */
	public static function newFromNumber( $amount, $unit = '1', $upperBound = null, $lowerBound = null ) {
		if ( !is_int( $amount ) && !is_float( $amount ) ) {
			throw new IllegalValueException( '$amount must be an int or float' );
		}

		if ( !is_null( $upperBound ) && !is_int( $upperBound ) && !is_float( $upperBound ) ) {
			throw new IllegalValueException( '$upperBound must be an int or float (or null)' );
		}

		if ( !is_null( $lowerBound ) && !is_int( $lowerBound ) && !is_float( $lowerBound ) ) {
			throw new IllegalValueException( '$lowerBound must be an int or float (or null)' );
		}

		$amount = new DecimalValue( $amount );

		if ( $upperBound === null ) {
			$upperBound = $amount;
		} else {
			$upperBound = new DecimalValue( $upperBound );
		}

		if ( $lowerBound === null ) {
			$lowerBound = $amount;
		} else {
			$lowerBound = new DecimalValue( $lowerBound );
		}

		return new QuantityValue( $amount, $unit, $upperBound, $lowerBound );
	}


	/**
	 * Returns a QuantityValue representing the given amount.
	 * If no upper or lower bound is given, the amount is assumed to be exact.
	 *
	 * @since 0.1
	 *
	 * @param string $amount
	 * @param string $unit
	 * @param string|null $upperBound
	 * @param string|null $lowerBound
	 *
	 * @return QuantityValue
	 * @throws IllegalValueException
	 */
	public static function newFromDecimal( $amount, $unit = '1', $upperBound = null, $lowerBound = null ) {
		if ( !is_string( $amount ) ) {
			throw new IllegalValueException( '$amount must be a string' );
		}

		if ( !is_null( $upperBound ) && !is_string( $upperBound ) ) {
			throw new IllegalValueException( '$upperBound must be a string' );
		}

		if ( !is_null( $lowerBound ) && !is_string( $lowerBound ) ) {
			throw new IllegalValueException( '$lowerBound must be a string' );
		}

		$amount = new DecimalValue( self::normalizeDecimal( $amount ) );


		if ( $upperBound === null ) {
			$upperBound = $amount;
		} else {
			$upperBound = new DecimalValue( self::normalizeDecimal( $upperBound ) );
		}

		if ( $lowerBound === null ) {
			$lowerBound = $amount;
		} else {
			$lowerBound = new DecimalValue( self::normalizeDecimal( $lowerBound ) );
		}

		return new QuantityValue( $amount, $unit, $upperBound, $lowerBound );
	}

	/**
	 * @param string $amount
	 *
	 * @return string
	 */
	private static function normalizeDecimal( $amount ) {
		$amount = preg_replace( '/^0+([^0])/', '\1', $amount );
		$amount = preg_replace( '/^0+([^0])/', '\1', $amount );

		if ( preg_match( '/^\./', $amount ) ) {
			$amount = '0' . $amount;
		}

		if ( preg_match( '/\.$/', $amount ) ) {
			$amount = $amount . '0';
		}

		if ( preg_match( '/^[0-9]/', $amount ) ) {
			$amount = '+' . $amount;
		}

		return $amount;
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function serialize() {
		$data = array(
			$this->amount,
			$this->unit,
			$this->upperBound,
			$this->lowerBound,
		);

		return serialize( $data );
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
		$data = unserialize( $data );

		$amount = array_shift( $data );
		$unit = array_shift( $data );
		$upperBound = array_shift( $data );
		$lowerBound = array_shift( $data );

		$this->__construct( $amount, $unit, $upperBound, $lowerBound);
	}

	/**
	 * @see DataValue::getType
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public static function getType() {
		return 'quantity';
	}

	/**
	 * @see DataValue::getSortKey
	 *
	 * @since 0.1
	 *
	 * @return float
	 */
	public function getSortKey() {
		return $this->getAmount()->getValueFloat();
	}

	/**
	 * Returns the quantity object.
	 * @see DataValue::getValue
	 *
	 * @since 0.1
	 *
	 * @return QuantityValue
	 */
	public function getValue() {
		return $this;
	}

	/**
	 * Returns the amount represented by this quantity.
	 *
	 * @since 0.1
	 *
	 * @return DecimalValue
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * Returns this quantity's upper bound.
	 *
	 * @since 0.1
	 *
	 * @return DecimalValue
	 */
	public function getUpperBound() {
		return $this->upperBound;
	}

	/**
	 * Returns this quantity's lower bound.
	 *
	 * @since 0.1
	 *
	 * @return DecimalValue
	 */
	public function getLowerBound() {
		return $this->lowerBound;
	}

	/**
	 * Returns the size of the uncertainty interval.
	 * This can roughly be interpreted as "amount +/- uncertainty/2".
	 *
	 * The exact interpretation of the uncertainty interval is left to the concrete application or
	 * data point. For example, the uncertainty interval may be defined to be that part of a
	 * normal distribution that is required to cover the 95th percentile.
	 *
	 * @since 0.1
	 *
	 * @return float
	 */
	public function getUncertainty() {
		return $this->getUpperBound()->getValueFloat() - $this->getLowerBound()->getValueFloat();
	}

	/**
	 * Returns a DecimalValue representing the symmetrical offset to be applied
	 * to the raw amount for a rough representation of the uncertainty interval,
	 * as in "amount +/- offset".
	 *
	 * The offset is calculated as max( amount - lowerBound, upperBound - amount ).
	 *
	 * @since 0.1
	 *
	 * @return DecimalValue
	 */
	public function getUncertaintyMargin() {
		//TODO: use bcmath if available
		$amount = $this->getAmount()->getValueFloat();
		$upperBound = $this->getUpperBound()->getValueFloat();
		$lowerBound = $this->getLowerBound()->getValueFloat();

		$offset = max( $amount - $lowerBound, $upperBound - $amount );
		return new DecimalValue( $offset );
	}

	/**
	 * Returns the number of significant digits in the amount-string,
	 * counting the decimal point, but not counting the leading sign.
	 *
	 * Note that this calculation assumes a symmetric uncertainty interval, and can be misleading
	 *
	 * @since 0.1
	 *
	 * @return int
	 */
	public function getSignificantDigits() {
		// the desired precision is given by the distance between the amount and
		// whatever is close, the uppoer or lower bound.
		//TODO: use bcmath if available
		$amount = $this->getAmount()->getValueFloat();
		$upperBound = $this->getUpperBound()->getValueFloat();
		$lowerBound = $this->getLowerBound()->getValueFloat();
		$precision = min( $amount - $lowerBound, $upperBound - $amount );

		if ( $precision === 0.0 ) {
			// include the decimal point, but not the sign
			$significantDigits = strlen( $this->amount->getValue() ) -1;
			return $significantDigits;
		}

		// e.g. +/- 200 -> 2; +/- 0.02 -> -2
		// note: we really want floor( $orderOfPrecision ), but have to account for
		// small errors made in the floating point operations above
		$orderOfPrecision = floor( log10( $precision + 0.0000000005 ) );

		// the length of the integer part is the reference point
		$significantDigits = strlen( $this->amount->getIntegerPart() );

		if ( $orderOfPrecision >= 0 ) {
			// e.g. 3000 +/- 100 -> 2 digits
			$significantDigits -= (int)$orderOfPrecision;
		} else {
			// e.g. 56.78 +/- 0.01 -> 5 digits
			$significantDigits += (int)(-$orderOfPrecision);
			$significantDigits += 1; // for the '.'
		}

		// assert sane value
		if ( $significantDigits <= 0 ) {
			throw new LogicException( 'Invalid calculation of significant digits' );
		}

		return $significantDigits;
	}

	/**
	 * Returns the unit held by this quantity.
	 * Unit-less quantities should use "1" as their unit.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getUnit() {
		return $this->unit;
	}

	/**
	 * Returns a transformed value derived from this QuantityValue by applying
	 * the given transformation to the amount and the upper and lower bounds.
	 * The resulting amount and bounds are rounded to the significant number of
	 * digits. Note that for exact quantities (with at least one bound equal to
	 * the amount), no rounding is applied (since they are considered to have
	 * infinite precision).
	 *
	 * The transformation is provided as a callback, which must implement a
	 * monotonously increasing, fully differentiable function mapping a DecimalValue
	 * to a DecimalValue. Typically, it will be a linear transformation applying a
	 * factor and an offset.
	 *
	 * @param string $newUnit The unit of the transformed quantity.
	 *
	 * @param callable $transformation A callback that implements the desired transformation.
	 *        The transformation will be called three times, once for the amount, once
	 *        for the lower bound, and once for the upper bound. It must return a DecimalValue.
	 *        The first parameter passed to $transformation is the DecimalValue to transform
	 *        In addition, any extra parameters passed to transform() will be passed through
	 *        to the transformation callback.
	 *
	 * @param mixed ... Any extra parameters will be passed to the $transformation function.
	 *
	 * @throws \InvalidArgumentException
	 * @return QuantityValue
	 */
	public function transform( $newUnit, $transformation ) {
		if ( !is_callable( $transformation ) ) {
			throw new \InvalidArgumentException( '$transformation must be callable.' );
		}

		if ( !is_string( $newUnit ) ) {
			throw new \InvalidArgumentException( '$newUnit must be a string. Use "1" as the unit for unit-less quantities.' );
		}

		if ( $newUnit === '' ) {
			throw new \InvalidArgumentException( '$newUnit must not be empty. Use "1" as the unit for unit-less quantities.' );
		}

		$oldUnit = $this->getUnit();

		if ( $newUnit === null ) {
			$newUnit = $oldUnit;
		}

		// Apply transformation by calling the $transform callback.
		// The first argument for the callback is teh DataValue to transform. In addition,
		// any extra arguments given for transform() are passed through.
		$args = func_get_args();
		array_shift( $args );

		$args[0] = $this->getAmount();
		$amount = call_user_func_array( $transformation, $args );

		$args[0] = $this->getUpperBound();
		$upperBound = call_user_func_array( $transformation, $args );

		$args[0] = $this->getLowerBound();
		$lowerBound = call_user_func_array( $transformation, $args );

		// use a preliminary QuantityValue to determine the significant number of digits
		$transformed = new QuantityValue( $amount, $newUnit, $upperBound, $lowerBound );
		$digits = $transformed->getSignificantDigits();

		// apply rounding to the significant digits
		$math = new DecimalMath(  ); //TODO: Perhaps transform() should go into a QuantityTransformer class.
		$amount = $math->round( $amount,  $digits );
		$upperBound = $math->round( $upperBound, $digits );
		$lowerBound = $math->round( $lowerBound, $digits );

		return new QuantityValue( $amount, $newUnit, $upperBound, $lowerBound );
	}

	/**
	 * @see DataValue::getArrayValue
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public function getArrayValue() {
		return array(
			'amount' => $this->amount->getArrayValue(),
			'unit' => $this->unit,
			'upperBound' => $this->upperBound->getArrayValue(),
			'lowerBound' => $this->lowerBound->getArrayValue(),
		);
	}

	/**
	 * Constructs a new instance of the DataValue from the provided data.
	 * This can round-trip with @see getArrayValue
	 *
	 * @since 0.1
	 *
	 * @param mixed $data
	 *
	 * @return QuantityValue
	 * @throws IllegalValueException
	 */
	public static function newFromArray( $data ) {
		self::requireArrayFields( $data, array( 'amount', 'unit', 'upperBound', 'lowerBound' ) );

		return new static(
			DecimalValue::newFromArray( $data['amount'] ),
			$data['unit'],
			DecimalValue::newFromArray( $data['upperBound'] ),
			DecimalValue::newFromArray( $data['lowerBound'] )
		);
	}
}

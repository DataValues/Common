<?php

namespace ValueFormatters\Exceptions;

use ValueFormatters\FormattingException;

/**
 * @since 0.2.1
 *
 * @licence GNU GPL v2+
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class DataValueTypeMismatchException extends FormattingException {

	/**
	 * @var string
	 */
	protected $expectedValueType;

	/**
	 * @var string
	 */
	protected $dataValueType;

	/**
	 * @param string $expectedValueType
	 * @param string $dataValueType
	 * @param string $message
	 * @param \Exception $previous
	 */
	public function __construct( $expectedValueType, $dataValueType, $message = '',
		\Exception $previous = null
	) {
		$this->expectedValueType = $expectedValueType;
		$this->dataValueType = $dataValueType;

		$message = "DataValueType $dataValueType does not match expected value "
			. "type $expectedValueType: " . $message;

		parent::__construct( $message, 0, $previous );
	}

	/**
	 * @return string
	 */
	public function getExpectedValueType() {
		return $this->expectedValueType;
	}

	/**
	 * @return string
	 */
	public function getDataValueType() {
		return $this->dataValueType;
	}

}

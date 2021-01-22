<?php

declare( strict_types = 1 );

namespace ValueFormatters\Exceptions;

use Exception;
use ValueFormatters\FormattingException;

/**
 * @since 0.2.2
 *
 * @license GPL-2.0-or-later
 * @author Katie Filbert < aude.wiki@gmail.com >
 * @author Thiemo Kreuz
 */
class MismatchingDataValueTypeException extends FormattingException {

	/**
	 * @var string
	 */
	private $expectedValueType;

	/**
	 * @var string
	 */
	private $dataValueType;

	/**
	 * @param string $expectedValueType
	 * @param string $dataValueType
	 * @param string $message
	 * @param Exception|null $previous
	 */
	public function __construct(
		$expectedValueType,
		$dataValueType,
		$message = '',
		Exception $previous = null
	) {
		$this->expectedValueType = $expectedValueType;
		$this->dataValueType = $dataValueType;

		if ( $message === '' ) {
			$message = 'Data value type "' . $dataValueType . '" does not match expected "'
				. $expectedValueType . '"';
		}

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

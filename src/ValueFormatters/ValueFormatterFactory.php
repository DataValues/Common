<?php

namespace ValueFormatters;

/**
 * Factory for creating ValueFormatter objects.
 *
 * @since 0.1
 *
 * @file
 * @ingroup ValueFormatters
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ValueFormatterFactory {

	/**
	 * Maps parser id to ValueFormatter class.
	 *
	 * @since 0.1
	 *
	 * @var ValueFormatter[]
	 */
	protected $formatters = array();

	/**
	 * @since 0.1
	 *
	 * @param string[] $valueFormatters
	 */
	public function __construct( array $valueFormatters ) {
		foreach ( $valueFormatters as $formatterId => $formatterClass ) {
			assert( is_string( $formatterId ) );
			assert( is_string( $formatterClass ) );

			$this->formatters[$formatterId] = $formatterClass;
		}
	}

	/**
	 * Returns the ValueFormatter identifiers.
	 *
	 * @since 0.1
	 *
	 * @return string[]
	 */
	public function getFormatterIds() {
		return array_keys( $this->formatters );
	}

	/**
	 * Returns class of the ValueFormatter with the provided id or null if there is no such ValueFormatter.
	 *
	 * @since 0.1
	 *
	 * @param string $formatterId
	 *
	 * @return string|null
	 */
	public function getFormatterClass( $formatterId ) {
		return array_key_exists( $formatterId, $this->formatters ) ? $this->formatters[$formatterId] : null;
	}

	/**
	 * Returns an instance of the ValueFormatter with the provided id or null if there is no such ValueFormatter.
	 *
	 * @since 0.1
	 *
	 * @param string $formatterId
	 * @param FormatterOptions $options
	 *
	 * @return ValueFormatter|null
	 */
	public function newFormatter( $formatterId, FormatterOptions $options ) {
		if ( !array_key_exists( $formatterId, $this->formatters ) ) {
			return null;
		}

		$instance = new $this->formatters[$formatterId]( $options );

		assert( $instance instanceof ValueFormatter );

		return $instance;
	}

}

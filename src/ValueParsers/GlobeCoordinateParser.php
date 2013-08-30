<?php

namespace ValueParsers;

use DataValues\GlobeCoordinateValue;
use DataValues\LatLongValue;

/**
 * Extends the GeoCoordinateParser by adding precision detection support.
 *
 * The object that gets constructed is a GlobeCoordinateValue rather then a LatLongValue.
 *
 * @since 0.1
 *
 * @file
 * @ingroup ValueParsers
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author H. Snater < mediawiki@snater.com >
 */
class GlobeCoordinateParser extends StringValueParser {

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @since 0.1
	 *
	 * @param string $value
	 *
	 * @return GlobeCoordinateValue
	 * @throws ParseException
	 */
	protected function stringParse( $value ) {
		foreach ( $this->getParsers() as $precisionDetector => $parser ) {
			try {
				$latLong = $parser->parse( $value );

				return new GlobeCoordinateValue(
					new LatLongValue(
						$latLong->getLatitude(),
						$latLong->getLongitude()
					),
					$this->detectPrecision( $latLong, $precisionDetector )
				);
			}
			catch ( ParseException $parseException ) {
				continue;
			}
		}

		throw new ParseException( 'The format of the coordinate could not be determined. Parsing failed.' );
	}

	protected function detectPrecision( LatLongValue $latLong, $precisionDetector ) {
		if ( $this->options->hasOption( 'precision' ) ) {
			return $this->options->getOption( 'precision' );
		}

		return min(
			call_user_func( array( $this, $precisionDetector ), $latLong->getLatitude() ),
			call_user_func( array( $this, $precisionDetector ), $latLong->getLongitude() )
		);
	}

	/**
	 * @return  StringValueParser[]
	 */
	protected function getParsers() {
		$parsers = array();

		$parsers['detectFloatPrecision'] = new FloatCoordinateParser( $this->options );
		$parsers['detectDmsPrecision'] = new DmsCoordinateParser( $this->options );
		$parsers['detectDmPrecision'] = new DmCoordinateParser( $this->options );
		$parsers['detectDdPrecision'] = new DdCoordinateParser( $this->options );

		return $parsers;
	}

	protected function detectDdPrecision( $number ) {
		// TODO: Implement localized decimal separator.
		$split = explode( '.', $number );

		$precision = 1;

		if( isset( $split[1] ) ) {
			$precision = pow( 10, -1 * strlen( $split[1] ) );
		}

		return $precision;
	}

	protected function detectDmPrecision( $number ) {
		$minutes = $number * 60;

		// Since arcminutes shall be used to detect the precision, precision needs at least to be an
		// arcminute:
		$precision = 1 / 60;

		// The minute may be a float; In order to detect a proper precision, we convert the minutes
		// to seconds.
		if( $minutes - floor( $minutes ) > 0 ) {
			$seconds = $minutes * 60;

			$precision = 1 / 3600;

			// TODO: Implement localized decimal separator.
			$secondsSplit = explode( '.', $seconds );

			if( isset( $secondsSplit[1] ) ) {
				$precision *= pow( 10, -1 * strlen( $secondsSplit[1] ) );
			}
		}

		return $precision;
	}

	protected function detectDmsPrecision( $number ) {
		$seconds = $number * 3600;

		// Since arcseconds shall be used to detect the precision, precision needs at least to be an
		// arcsecond:
		$precision = 1 / 3600;

		if( $number - floor( $number ) > 0 ) {
			// TODO: Implement localized decimal separator.
			$secondsSplit = explode( '.', $seconds );

			if( isset( $secondsSplit[1] ) ) {
				$precision *= pow( 10, -1 * strlen( $secondsSplit[1] ) );
			}
		}

		return $precision;
	}

	protected function detectFloatPrecision( $number ) {
		// TODO: Implement localized decimal separator.
		$split = explode( '.', $number );

		$precision = 1;

		if( isset( $split[1] ) ) {
			$precision = pow( 10, -1 * strlen( $split[1] ) );
		}

		return $precision;
	}

}

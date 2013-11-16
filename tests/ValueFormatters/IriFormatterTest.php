<?php

namespace ValueFormatters\Test;

use DataValues\IriValue;

/**
 * Unit tests for the ValueFormatters\GeoCoordinateFormatter class.
 *
 * @file
 * @since 0.1
 *
 * @ingroup ValueFormattersTest
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class IriFormatterTest extends ValueFormatterTestBase {

	/**
	 * @see ValueFormatterTestBase::validProvider
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public function validProvider() {
		$argLists = array();

		$argLists[] = array(
			new IriValue(
				'http',
				'//www.wikidata.org'
			),
			'http://www.wikidata.org'
		);

		$argLists[] = array(
			new IriValue(
				'http',
				'//www.wikidata.org',
				'type=animal&name=narwhal'
			),
			'http://www.wikidata.org?type=animal&name=narwhal'
		);

		$argLists[] = array(
			new IriValue(
				'http',
				'//www.wikidata.org',
				'type=animal&name=narwhal',
				'headerSection'
			),
			'http://www.wikidata.org?type=animal&name=narwhal#headerSection'
		);

		$argLists[] = array(
			new IriValue(
				'http',
				'//www.wikidata.org',
				'',
				'headerSection'
			),
			'http://www.wikidata.org#headerSection'
		);

		$argLists[] = array(
			new IriValue(
				'irc',
				'//en.wikipedia.org',
				'',
				''
			),
			'irc://en.wikipedia.org'
		);

		return $argLists;
	}

	/**
	 * @see ValueFormatterTestBase::getFormatterClass
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected function getFormatterClass() {
		return 'ValueFormatters\IriFormatter';
	}

}

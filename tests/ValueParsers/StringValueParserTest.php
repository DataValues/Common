<?php

namespace ValueParsers\Test;

use ValueParsers\StringValueParser;

/**
 * Unit test StringValueParser class.
 *
 * @since 0.1
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class StringValueParserTest extends ValueParserTestBase {

	/**
	 * @see ValueParserTestBase::invalidInputProvider
	 *
	 * @return array[]
	 */
	public function invalidInputProvider() {
		return array(
			array( true ),
			array( false ),
			array( null ),
			array( 4.2 ),
			array( array() ),
			array( 42 ),
		);
	}

	public function testSetAndGetOptions() {
		$options = $this->newParserOptions();

		/**
		 * @var StringValueParser $parser
		 */
		$parser = $this->getInstance();

		$parser->setOptions( $options );

		$this->assertEquals( $options, $parser->getOptions() );

		$options = $this->newParserOptions();
		$options->setOption( '~=[,,_,,]:3', '~=[,,_,,]:3' );

		$parser->setOptions( $options );

		$this->assertEquals( $options, $parser->getOptions() );
	}

}

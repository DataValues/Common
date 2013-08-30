<?php

namespace ValueParsers\Test;

use ValueParsers\ValueParserFactory;

/**
 * @covers ValueParsers\ValueParserFactory
 *
 * @file
 * @since 0.1
 *
 * @ingroup ValueParsersTest
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ValueParserFactoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @since 0.1
	 *
	 * @return ValueParserFactory
	 */
	protected function newFactory() {
		return new ValueParserFactory( array(
			'null' => 'ValueParsers\NullParser'
		) );
	}

	public function testGetParserIds() {
		$ids = $this->newFactory()->getParserIds();
		$this->assertInternalType( 'array', $ids );

		foreach ( $ids as $id ) {
			$this->assertInternalType( 'string', $id );
		}

		$this->assertEquals( array_unique( $ids ), $ids );
	}

	public function testGetParser() {
		$factory = $this->newFactory();

		$options = new \ValueParsers\ParserOptions();

		foreach ( $factory->getParserIds() as $id ) {
			try {
				$parser = $factory->newParser( $id, $options );
				$this->assertInstanceOf( 'ValueParsers\ValueParser', $parser );
			}
			catch ( \Exception $ex ) {
				$this->assertTrue( true, 'Exceptions can be raised due to not providing required options' );
			}
		}

		$this->assertInternalType( 'null', $factory->newParser( "I'm in your tests, being rather silly ~=[,,_,,]:3", $options ) );
	}

	public function testGetParserClass() {
		$factory = $this->newFactory();

		foreach ( $factory->getParserIds() as $id ) {
			$this->assertInternalType( 'string', $factory->getParserClass( $id ) );
		}

		$this->assertInternalType( 'null', $factory->getParserClass( "I'm in your tests, being rather silly ~=[,,_,,]:3" ) );
	}

}

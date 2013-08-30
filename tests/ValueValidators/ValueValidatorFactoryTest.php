<?php

namespace ValueValidators\Test;

use ValueValidators\ValueValidatorFactory;

/**
 * @covers ValueValidators\ValueValidatorFactory
 *
 * @file
 * @since 0.1
 *
 * @ingroup ValueValidatorsTest
 *
 * @group ValueValidators
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ValueValidatorFactoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @since 0.1
	 *
	 * @return ValueValidatorFactory
	 */
	protected function newFactory() {
		return new ValueValidatorFactory( array(
			'null' => 'ValueValidators\NullValidator',
		) );
	}

	public function testGetValidatorIds() {
		$ids = $this->newFactory()->getValidatorIds();
		$this->assertInternalType( 'array', $ids );

		foreach ( $ids as $id ) {
			$this->assertInternalType( 'string', $id );
		}

		$this->assertEquals( array_unique( $ids ), $ids );
	}

	public function testGetValidator() {
		$factory = $this->newFactory();

		foreach ( $factory->getValidatorIds() as $id ) {
			$this->assertInstanceOf( 'ValueValidators\ValueValidator', $factory->newValidator( $id ) );
		}

		$this->assertInternalType( 'null', $factory->newValidator( "I'm in your tests, being rather silly ~=[,,_,,]:3" ) );
	}

	public function testGetValidatorClass() {
		$factory = $this->newFactory();

		foreach ( $factory->getValidatorIds() as $id ) {
			$this->assertInternalType( 'string', $factory->getValidatorClass( $id ) );
		}

		$this->assertInternalType( 'null', $factory->getValidatorClass( "I'm in your tests, being rather silly ~=[,,_,,]:3" ) );
	}

}

<?php

namespace ValueFormatters\Tests\Exceptions;

use ValueFormatters\Exceptions\DataValueTypeMismatchException;

/**
 * @covers ValueFormatters\Exceptions\DataValueTypeMismatchException
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class DataValueTypeMismatchExceptionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider constructorProvider
	 */
	public function testConstructorWithRequiredArguments( $expectedType, $actualType ) {
		$exception = new DataValueTypeMismatchException( $expectedType, $actualType );

		$this->assertEquals( $actualType, $exception->getDataValueType() );
		$this->assertEquals( $expectedType, $exception->getExpectedValueType() );
	}

	/**
	 * @dataProvider constructorProvider
	 */
	public function testConstructorWithAllArguments( $expectedType, $actualType ) {
		$message = 'Onoez! an error!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new DataValueTypeMismatchException(
			$expectedType,
			$actualType,
			$message,
			$previous
		);

		$this->assertEquals( $actualType, $exception->getDataValueType() );
		$this->assertEquals( $expectedType, $exception->getExpectedValueType() );
		$this->assertContains( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

	public function constructorProvider() {
		return array(
			array( 'string', 'time' ),
			array( 'globecoordinate', 'string' )
		);
	}

}

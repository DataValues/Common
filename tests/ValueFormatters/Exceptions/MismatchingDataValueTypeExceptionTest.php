<?php

namespace ValueFormatters\Tests\Exceptions;

use Exception;
use PHPUnit_Framework_TestCase;
use ValueFormatters\Exceptions\MismatchingDataValueTypeException;

/**
 * @covers ValueFormatters\Exceptions\MismatchingDataValueTypeException
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Katie Filbert < aude.wiki@gmail.com >
 * @author Thiemo Mättig
 */
class MismatchingDataValueTypeExceptionTest extends PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider constructorProvider
	 */
	public function testConstructorWithRequiredArguments( $expectedType, $actualType ) {
		$exception = new MismatchingDataValueTypeException( $expectedType, $actualType );

		$this->assertSame( $expectedType, $exception->getExpectedValueType() );
		$this->assertSame( $actualType, $exception->getDataValueType() );
		$this->assertSame(
			"Data value type \"$actualType\" does not match expected \"$expectedType\"",
			$exception->getMessage()
		);
		$this->assertNull( $exception->getPrevious() );
	}

	/**
	 * @dataProvider constructorProvider
	 */
	public function testConstructorWithAllArguments( $expectedType, $actualType ) {
		$message = 'Onoez! an error!';
		$previous = new Exception( 'Onoez!' );

		$exception = new MismatchingDataValueTypeException(
			$expectedType,
			$actualType,
			$message,
			$previous
		);

		$this->assertSame( $expectedType, $exception->getExpectedValueType() );
		$this->assertSame( $actualType, $exception->getDataValueType() );
		$this->assertSame( $message, $exception->getMessage() );
		$this->assertSame( $previous, $exception->getPrevious() );
	}

	public function constructorProvider() {
		return array(
			array( 'string', 'time' ),
			array( 'globecoordinate', 'string' )
		);
	}

}

<?php

declare( strict_types = 1 );

namespace ValueFormatters\Tests\Exceptions;

use Exception;
use PHPUnit\Framework\TestCase;
use ValueFormatters\Exceptions\MismatchingDataValueTypeException;

/**
 * @covers \ValueFormatters\Exceptions\MismatchingDataValueTypeException
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @license GPL-2.0-or-later
 * @author Katie Filbert < aude.wiki@gmail.com >
 * @author Thiemo Kreuz
 */
class MismatchingDataValueTypeExceptionTest extends TestCase {

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
		return [
			[ 'string', 'time' ],
			[ 'globecoordinate', 'string' ]
		];
	}

}

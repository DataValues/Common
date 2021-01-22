# DataValues Common

DataValues Common is a small library build on top of DataValues that provides common
implementations of the DataValues, ValueParsers, ValueFormatters and ValueValidators interfaces.

It is part of the [DataValues set of libraries](https://github.com/DataValues).

[![Code Coverage](https://scrutinizer-ci.com/g/DataValues/Common/badges/coverage.png?s=728b9287ebdd13fbe15255d4d55575c5b5d47b8f)](https://scrutinizer-ci.com/g/DataValues/Common/)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/DataValues/Common/badges/quality-score.png?s=3195539d2e929aafaefb4bc006fb0da6c09a4d2a)](https://scrutinizer-ci.com/g/DataValues/Common/)

On [Packagist](https://packagist.org/packages/data-values/common):
[![Latest Stable Version](https://poser.pugx.org/data-values/common/version.png)](https://packagist.org/packages/data-values/common)
[![Download count](https://poser.pugx.org/data-values/common/d/total.png)](https://packagist.org/packages/data-values/common)

## Installation

The recommended way to use this library is via [Composer](http://getcomposer.org/).

To add this package as a local, per-project dependency to your project, simply add a
dependency on `data-values/common` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
version 1.x of this package:

    {
        "require": {
            "data-values/common": "^1.0.0"
        }
    }

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via Github Actions.

### Running the tests

For tests only

    composer test

For style checks only

	composer cs

For a full CI run

	composer ci

## Authors

DataValues Common has been written by the Wikidata team, as [Wikimedia Germany](https://wikimedia.de)
employees for the [Wikidata project](https://wikidata.org/).

## Release notes

### 1.0.0 (2021-01-22)

* Updated minimum required PHP version from 5.5.9 to 7.2
* Added compatibility with `data-values/data-values` 3.x
* Added compatibility with `data-values/interfaces` 1.x
* Removed the `DATAVALUES_COMMON_VERSION` constant
* Deprecated `getSortKey` methods from `DataValue` implementations
* Classes in the `ValueParsers\Test` namespace are now package private. Notably `ValueParserTestBase` and `StringValueParserTest`
* The `StringFormatter` constructor does not accept options any more
* `StringParser::parse` now throws a `ParseException` instead of an `InvalidArgumentException`
* Added `TrimmingStringNormalizer`
* Made `FORMAT_NAME` constants in the Parser classes private

### 0.4.3 (2019-06-28)

* Fixed typo in error message in `DispatchingValueParser`

### 0.4.2 (2018-08-16)

* The component can now be installed together with DataValues 2.x

### 0.4.1 (2017-08-09)

* Fixed version number not updated before.

### 0.4.0 (2017-08-09)

* Deprecated `MonolingualTextValue::newFromArray` and `MultilingualTextValue::newFromArray`
* `MismatchingDataValueTypeException` no longer modifies custom error messages in its constructor
* Updated minimal required PHP version from 5.3 to 5.5.9
* Updated the MediaWiki entry point to use the extension.json format

### 0.3.1 (2015-08-14)

* The component can now be installed together with DataValues Interfaces 0.1.5

### 0.3.0 (2015-08-11)

* Added `DispatchingValueParser`
* Added `StringNormalizer` interface
* Added `NullStringNormalizer`
* Added `StringParser`
* Dropped deprecated constant `DataValuesCommon_VERSION`, use `DATAVALUES_COMMON_VERSION` instead
* Dropped `ValueParserTestBase::getParserClass`
* Dropped `ValueParserTestBase::newParserOptions`
* Made `ValueParserTestBase::getInstance` abstract
* Made `ValueParserTestBase::invalidInputProvider` abstract
* Lowered visibility of all class fields to private

### 0.2.3 (2014-10-09)

* Introduced `FORMAT_NAME` class constants on ValueParsers in order to use them as expectedFormat
* Changed ValueParsers to pass rawValue and expectedFormat arguments when constructing a `ParseException`
* Installation together with DataValues 1.x is now supported

### 0.2.2 (2014-04-11)

* Added `MismatchingDataValueTypeException`

### 0.2.1 (2014-03-12)

* Minor code cleanup
* Improved PHPUnit bootstrap

### 0.2.0 (2013-12-16)

* Added FloatParser (moved from data-values/number)
* Added IntParser (moved from data-values/number)

### 0.1.1 (2013-11-22)

* Fixed link in the MediaWiki credits

### 0.1.0 (2013-11-17)

Initial release with these features:

* Several DataValue implementations
	* MonolingualTextValue
	* MultilingualTextValue
* Several ValueFormatter implementations
	* StringFormatter
* Several ValueParser implementations
	* BoolParser
	* DecimalParser
	* NullParser

## Links

* [DataValues Common on Packagist](https://packagist.org/packages/data-values/common)

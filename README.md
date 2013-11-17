# DataValues Common

DataValues Common is a small library build on top of DataValues that provides common
implementations of the DataValues, ValueParsers, ValueFormatters and ValueValidators interfaces.

It is part of the [DataValues set of libraries](https://github.com/DataValues).

[![Build Status](https://secure.travis-ci.org/DataValues/Common.png?branch=master)](http://travis-ci.org/DataValues/Common)
[![Coverage Status](https://coveralls.io/repos/DataValues/Common/badge.png?branch=master)](https://coveralls.io/r/DataValues/Common?branch=master)

On [Packagist](https://packagist.org/packages/data-values/common):
[![Latest Stable Version](https://poser.pugx.org/data-values/common/version.png)](https://packagist.org/packages/data-values/common)
[![Download count](https://poser.pugx.org/data-values/common/d/total.png)](https://packagist.org/packages/data-values/common)

## Installation

The recommended way to use this library is via [Composer](http://getcomposer.org/).

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `data-values/common` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
version 1.0 of this package:

    {
        "require": {
            "data-values/common": "1.0.*"
        }
    }

### Manual

Get the code of this package, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Then take care of autoloading the classes defined in the src directory.

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

DataValues Common has been written by the Wikidata team, as [Wikimedia Germany]
(https://wikimedia.de) employees for the [Wikidata project](https://wikidata.org/).

## Release notes

### 0.1 (2013-11-17)

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
* [DataValues Common on TravisCI](https://travis-ci.org/DataValues/Common)
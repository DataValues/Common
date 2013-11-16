# DataValues Common

DataValues Common is a small library build on top of DataValues that provides common
implementations of the DataValues, ValueParsers, ValueFormatters and ValueValidators interfaces.

[![Build Status](https://secure.travis-ci.org/JeroenDeDauw/DataValuesCommon.png?branch=master)](http://travis-ci.org/JeroenDeDauw/DataValuesCommon)

On [Packagist](https://packagist.org/packages/data-values/common):
[![Latest Stable Version](https://poser.pugx.org/data-values/common/version.png)](https://packagist.org/packages/data-values/common)
[![Download count](https://poser.pugx.org/data-values/common/d/total.png)](https://packagist.org/packages/data-values/common)

## Requirements

* PHP 5.3 or later
* [DataValues](https://packagist.org/packages/data-values/data-values) -
see composer.json to get the required version
* [DataValues Interfaces](https://packagist.org/packages/data-values/interfaces) -
see composer.json to get the required version

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `data-values/common` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
DataValues Common 1.0:

    {
        "require": {
            "data-values/common": "1.0.*"
        }
    }

### Manual

Get the DataValues Common code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Load all dependencies and the load the DataValues Common library by including its entry point:
DataValuesCommon.php.

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

DataValues Common has been written by the Wikidata team, as [Wikimedia Germany]
(https://wikimedia.de) employees for the [Wikidata project](https://wikidata.org/).

## Release notes

### 0.1 (dev)

Initial release with these features:

*

## Links

* [DataValues Common on Packagist](https://packagist.org/packages/data-values/common)
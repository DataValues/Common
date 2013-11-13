# DataValues Common

DataValues Common is a small library build on top of DataValues that provides common
implementations of the DataValues, ValueParsers, ValueFormatters and ValueValidators interfaces.

Recent changes can be found in the [release notes](docs/RELEASE-NOTES.md).

[![Build Status](https://secure.travis-ci.org/JeroenDeDauw/DataValuesCommon.png?branch=master)](http://travis-ci.org/JeroenDeDauw/DataValuesCommon)

On [Packagist](https://packagist.org/packages/data-values/common):
[![Latest Stable Version](https://poser.pugx.org/data-values/common/version.png)](https://packagist.org/packages/data-values/common)
[![Download count](https://poser.pugx.org/data-values/common/d/total.png)](https://packagist.org/packages/data-values/common)

## Requirements

* PHP 5.3 or later
* DataValues - see composer.json to get the required version
* DataValues Interfaces - see composer.json to get the required version

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
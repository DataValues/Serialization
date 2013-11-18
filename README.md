# DataValues Serialization

Serializers and deserializers for DataValue implementations.

It is part of the [DataValues set of libraries](https://github.com/DataValues).

[![Build Status](https://secure.travis-ci.org/DataValues/Serialization.png?branch=master)](http://travis-ci.org/DataValues/Serialization)
[![Coverage Status](https://coveralls.io/repos/DataValues/Serialization/badge.png)](https://coveralls.io/r/DataValues/Serialization)

On [Packagist](https://packagist.org/packages/data-values/serialization):
[![Latest Stable Version](https://poser.pugx.org/data-values/serialization/version.png)](https://packagist.org/packages/data-values/serialization)
[![Download count](https://poser.pugx.org/data-values/serialization/d/total.png)](https://packagist.org/packages/data-values/serialization)

## Installation

The recommended way to use this library is via [Composer](http://getcomposer.org/).

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `data-values/serialization` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
version 1.0 of this package:

    {
        "require": {
            "data-values/serialization": "1.0.*"
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

DataValues Serialization has been written by [Jeroen De Dauw](https://github.com/JeroenDeDauw),
as [Wikimedia Germany](https://wikimedia.de) employee for the [Wikidata project](https://wikidata.org/).

## Release notes

### 0.1 (dev)

Initial release with these features:



## Links

* [DataValues Serialization on Packagist](https://packagist.org/packages/data-values/serialization)
* [DataValues Serialization on TravisCI](https://travis-ci.org/DataValues/Serialization)

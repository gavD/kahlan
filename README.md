# Kahlan

[![Build Status](https://travis-ci.org/crysalead/kahlan.png?branch=master)](https://travis-ci.org/crysalead/kahlan) [![Code Coverage](https://scrutinizer-ci.com/g/crysalead/kahlan/badges/coverage.png?s=5af80e51db6c0879b1cd47d5dc4c0ff24c4e9cf2)](https://scrutinizer-ci.com/g/crysalead/kahlan/) [![Coverage Status](https://coveralls.io/repos/crysalead/kahlan/badge.png?branch=master)](https://coveralls.io/r/crysalead/kahlan?branch=master)

Kahlan is a full-featured Unit & BDD test framework a la RSpec/JSpec using a `describe-it` syntax and moves testing in PHP one step forward.

Kahlan embrace the [KISS principle](http://en.wikipedia.org/wiki/KISS_principle) and makes Unit & BDD testing fun again.

**Killer feature:** Kahlan allows to stub or monkey patch your code directly like in Ruby or JavaScript without any required PECL-extentions.

# Documentation

See the whole [documentation here](docs/README.md).

# Requirements

 * PHP 5.4+
 * Using Composer
 * Xdebug if you want to perform code coverage analysis.

# Screenshot

Example of output:
![Kahlan](docs/assets/kahlan.png)

Example of detailed code coverage on a specific scope.
![code_coverage_example](docs/assets/code_coverage_example.png)

# Installation

```
git clone git@github.com:crysalead/kahlan.git
cd kahlan
composer install
bin/kahlan              # to run specs or,
bin/kahlan --coverage=4 # to run specs with coverage info for namespaces, classes & methods (require xdebug)
```

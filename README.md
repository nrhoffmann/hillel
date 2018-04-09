# Hillel

[![Coverage Status](https://coveralls.io/repos/github/nrhoffmann/hillel/badge.svg?branch=master&type=github)](https://coveralls.io/github/nrhoffmann/hillel?branch=master)
[![Build Status](https://travis-ci.org/nrhoffmann/hillel.svg?branch=master&type=github)](https://travis-ci.org/nrhoffmann/hillel)

## Requirements

- PHP >= 7.1

## Installation
```sh
$composer require nrhoffmann/hillel
```
## Usage

Make a `tarich` representing a date
```PHP
$tarich = Tarich::fromGorgarian(9, 30, 2017);
```
Test the `tarich`
```PHP
$tarich->isYomKippur(); // true
```

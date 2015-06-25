# GisgraphyBundle

This is a simple Symfony wrapper for parsing address data from [gisgraphy](http://www.gisgraphy.com/).

## Installation

Install is done via `composer`:

```zsh
$ composer require wikibusiness/gisgraphy-bundle
```

## Usage

```php
$address     = '1600 Amphitheatre Parkway Mountain View CA';
$countryCode = 'us';

$gis        = new Gisgraphy($address, $countryCode);
$gisAddress = $gis->decode();

var_dump($gisAddress);
var_dump($gisAddress->toArray());
var_dump($gisAddress->getKeys());
var_dump($gisAddress->getZipcode());
```

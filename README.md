# Geocoder

This is the Geocoder module for Drupal 7.
This is a complete rewrite of the code, based on the [Geocoder PHP library](http://geocoder-php.org).

# Features
* Solid API based on [Geocoder PHP library](http://geocoder-php.org),
* Geocode and Reverse Geocode using one or multiple providers,
* Results can be dumped into multiple formats,
* Submodule Geocoder Field: provides Drupal fields widgets and formatters, with even more options,
* Submodule Geocoder Services: provides a Geocoding and reverse geocoding service through the contrib module Services,
* File geocoding, Addressfield integration, caching enabled by default.

# Requirements
* [Composer](https://getcomposer.org/)
* [Drush](http://drush.org)
* Contrib module [Service Container](https://www.drupal.org/project/service_container)
* Contrib module [Composer Manager](https://www.drupal.org/project/composer_manager)

# Installation
* Install the contrib module [Service Container](https://www.drupal.org/project/service_container) which is now a requirement.
* Install the contrib module [Composer Manager](https://www.drupal.org/project/composer_manager).
* Read the documentation of Composer Manager to install dependencies. Basically with drush: drush dl composer-8.x, drush composer-json-rebuild, drush composer-manager install.
* Enable the module.

This modules needs external libraries to work. Those libraries can be installed anywhere but to avoid messing with files and duplicates we're using the module Composer Manager.
Composer manager will install all those libraries in 'sites/all/libraries/composer' and they will be available in Drupal without the need to include a the autoload.php file, it's automatically done for you.
Please, read carefully the documentation, make sure you have all the requirements on your system and everything should be ok.

# Links
* [Service container module](https://www.drupal.org/project/service_container)
* [Geocoder module](https://www.drupal.org/project/geocoder)
* [Geocoder PHP](http://geocoder-php.org/)
* [Composer](https://getcomposer.org/)
* [Drush](http://drush.org)

# API

## Get a list of all available plugins

```php
$plugins = \Drupal\geocoder\Geocoder::getPlugins();
```

## Get a list of available Provider plugins only

```php
$providers = \Drupal\geocoder\Geocoder::getPlugins('Provider');
```

## Get a list of available Dumper plugins only

```php
$dumpers = \Drupal\geocoder\Geocoder::getPlugins('Dumper');
```

## Geocode a string

```php
$plugins = array('geonames', 'googlemaps', 'bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';
$options = array(
  'geonames' => array(), // array of options
  'googlemaps' => array(), // array of options
  'bingmaps' => array(), // array of options
);

$addressCollection = \Drupal\geocoder\Geocoder::geocode($plugins, $address, $options);
// or
$addressCollection = geocode($plugins, $address, $options);
```

## Reverse geocode coordinates

```php
$plugins = array('freegeoip', 'geonames', 'googlemaps', 'bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';
$options = array(
  'freegeoip' => array(), // array of options
  'geonames' => array(), // array of options
  'googlemaps' => array(), // array of options
  'bingmaps' => array(), // array of options
);

$addressCollection = \Drupal\geocoder\Geocoder::reverse($plugins, $address, $options);
// or
$addressCollection = reverse($plugins, $address, $options);
```

## Return format

Both ```Geocoder::geocode()``` and ```Geocoder::reverse()``` and both ```reverse()``` and ```geocode()``` returns the same object: ```Geocoder\Model\AddressCollection```, which is itself composed of ```Geocoder\Model\Address```.

You can transform those objects into arrays. Example:

```php
$plugins = array('geonames', 'googlemaps', 'bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';
$options = array(
  'geonames' => array(), // array of options
  'googlemaps' => array(), // array of options
  'bingmaps' => array(), // array of options
);

$addressCollection = \Drupal\geocoder\Geocoder::geocode($plugins, $address, $options);
$address_array = $addressCollection->first()->toArray();

// You can play a bit more with the API

$addressCollection = \Drupal\geocoder\Geocoder::geocode($plugins, $address, $options);
$latitude = $addressCollection->first()->getCoordinates()->getLatitude();
$longitude = $addressCollection->first()->getCoordinates()->getLongitude();
```

You can also convert these to different formats using the Dumper plugins.
Get the list of available Dumper by doing:

```php
\Drupal\geocoder\Geocoder::getPlugins('Dumper')
```

Here's an example on how to use a Dumper

```php
$plugins = array('geonames', 'googlemaps', 'bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';

$addressCollection = \Drupal\geocoder\Geocoder::geocode($plugins, $address);
$geojson = \Drupal\geocoder\Geocoder::getPlugin('Dumper', 'geojson')->dump($addressCollection->first());
```

There's also a dumper for GeoPHP, here's how to use it

```php
$plugins = array('geonames', 'googlemaps', 'bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';

$addressCollection = \Drupal\geocoder\Geocoder::geocode($plugins, $address);
$geometry = \Drupal\geocoder\Geocoder::getPlugin('Dumper', 'geometry')->dump($addressCollection->first());
```

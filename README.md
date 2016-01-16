# Geocoder

This is the Geocoder module for Drupal 7 rewritten using the Geocoder PHP library.

# Requirements
* [Composer](https://getcomposer.org/)
* [Drush](http://drush.org)

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

## Get a list of available Provider plugins

```php
\Drupal\geocoder\Geocoder::getPlugins('Provider')
```

## Get a list of available Dumper plugins

```php
\Drupal\geocoder\Geocoder::getPlugins('Dumper')
```

## Geocode a string

```php
$plugins = array('Geonames', 'GoogleMaps', 'Bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';
$options = array(
  'Geonames' => array(), // array of options
  'GoogleMaps' => array(), // array of options
  'BingMaps' => array(), // array of options
);

$addressCollection = \Drupal\geocoder\Geocoder::geocode($plugins, $address, $options);
// or
$addressCollection = geocode($plugins, $address, $options);
```

## Reverse geocode coordinates

```php
$plugins = array('FreeGeoIp', 'Geonames', 'GoogleMaps', 'Bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';
$options = array(
  'FreeGeoIp' => array(), // array of options
  'Geonames' => array(), // array of options
  'GoogleMaps' => array(), // array of options
  'BingMaps' => array(), // array of options
);

$addressCollection = \Drupal\geocoder\Geocoder::reverse($plugins, $address, $options);
// or
$addressCollection = reverse($plugins, $address, $options);
```

## Return format

Both ```Geocoder::geocode()``` and ```Geocoder::reverse()``` and both ```reverse()``` and ```geocode()``` returns the same object: ```Geocoder\Model\AddressCollection```, which is itself composed of ```Geocoder\Model\Address```.

You can transform those objects into arrays. Example:

```php
$plugins = array('Geonames', 'GoogleMaps', 'Bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';
$options = array(
  'Geonames' => array(), // array of options
  'GoogleMaps' => array(), // array of options
  'BingMaps' => array(), // array of options
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
$plugins = array('Geonames', 'GoogleMaps', 'Bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';

$addressCollection = \Drupal\geocoder\Geocoder::geocode($plugins, $address, $options);
$geojson = \Drupal\geocoder\Geocoder::getPlugin('Dumper', 'geojson')->dump($addressCollection->first());
```

There's also a dumper for GeoPHP, here's how to use it

```php
$plugins = array('Geonames', 'GoogleMaps', 'Bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';

$addressCollection = \Drupal\geocoder\Geocoder::geocode($plugins, $address, $options);
$geometry = \Drupal\geocoder\Geocoder::getPlugin('Dumper', 'geometry')->dump($addressCollection->first());
```

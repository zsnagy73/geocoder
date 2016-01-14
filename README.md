# Geocoder

This is the Geocoder module for Drupal 7 rewritten using the Geocoder PHP library.

# Installation
* Install the contrib module [Service Container](https://www.drupal.org/project/service_container) which is now a requirement.
* Install the contrib module [Composer Manager](https://www.drupal.org/project/composer_manager).
* Read the documentation of Composer Manager to install dependencies. Basically with drush: drush dl composer-8.x, drush composer-json-rebuild, drush composer-manager install.
* Enable the module.

# Links
* [Service container module](https://www.drupal.org/project/service_container)
* [Geocoder module](https://www.drupal.org/project/geocoder)
* [Geocoder PHP](http://geocoder-php.org/)

# API

## Get a list of available plugins

```\Drupal\geocoder\Geocoder::getPlugins()```

## Geocode a string

```php
$plugins = array('Geonames', 'GoogleMaps', 'Bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';
$options = array(
  'Geonames' => array(), // array of options
  'GoogleMaps' => array(), // array of options
  'BingMaps' => array(), // array of options
);

$address = \Drupal\geocoder\Geocoder::geocode($plugins, $address, $options);
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

$address = \Drupal\geocoder\Geocoder::reverse($plugins, $address, $options);
```

## Return format

Both ```Geocoder::geocode()``` and ```Geocoder::reverse()``` returns the same object: an ```Geocoder\Model\AddressCollection```, which is itself composed of ```Geocoder\Model\Address```.

You can transform those objects into arrays. Example:

```php
$plugins = array('Geonames', 'GoogleMaps', 'Bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';
$options = array(
  'Geonames' => array(), // array of options
  'GoogleMaps' => array(), // array of options
  'BingMaps' => array(), // array of options
);

$address = \Drupal\geocoder\Geocoder::geocode($plugins, $address, $options);
$address_array = $address->first()->toArray();

// Or you can play a bit more with the API

$address = \Drupal\geocoder\Geocoder::geocode($plugins, $address, $options);
$latitude = $address->getCoordinates()->getLatitude();
$longitude = $address->getCoordinates()->getLongitude();
```
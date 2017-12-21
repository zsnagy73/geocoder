# Geocoder 8.x-2.x

This is the Geocoder module for Drupal 8 rewritten using the
[Geocoder PHP library](http://geocoder-php.org)

# Requirements
* [Composer](https://getcomposer.org/) to add the module to your codebase (for more info refer to [Using Composer to manage Drupal site dependencies](https://www.drupal.org/node/2718229)
* No other external requirements for the main geocoder Module: the [Geocoder PHP library](http://geocoder-php.org) will be downloaded automatically with the composer require (see below)
* The embedded "Geocoder Geofield" submodule require the [Geofield Module](https://www.drupal.org/project/geofield)
* The embedded "Geocoder Address" submodule require the [Address Module](https://www.drupal.org/project/address)

# Installation
* Download the module: from you project root, at the composer.json file level run:  
  ```composer require drupal/geocoder```  
  **Note:** this will also download the Geocoder PHP library as vendor/willdurand/geocoder
* Enable the module via [Drush](http://drush.org)  
 ```drush en geocoder```  
 or the website back-end/administration interface.
* Eventually enable also the submodules: ```geocoder_field``` and ```geocoder_geofield``` / ```geocoder_address```.

# Features
* Provides options to geocode a field from a string into a geographic data format such as WKT, GeoJson, etc etc...
* The Provider and Dumper plugins are extendable through a custom module,
* All successful requests are cached by default.

# API

## Get a list of available Provider plugins

```php
\Drupal::service('plugin.manager.geocoder.provider')->getDefinitions()
```

## Get a list of available Dumper plugins

```php
\Drupal::service('plugin.manager.geocoder.dumper')->getDefinitions();
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

$addressCollection = \Drupal::service('geocoder')->geocode($address, $plugins, $options);
```

## Reverse geocode coordinates

```php
$plugins = array('freegeoip', 'geonames', 'googlemaps', 'bingmaps');
$lat = '37.422782';
$lon = '-122.085099';
$options = array(
  'freegeoip' => array(), // array of options
  'geonames' => array(), // array of options
  'googlemaps' => array(), // array of options
  'bingmaps' => array(), // array of options
);

$addressCollection = \Drupal::service('geocoder')->reverse($lat, $lon, $plugins, $options);
```

## Return format

Both ```Geocoder::geocode()``` and ```Geocoder::reverse()```
return the same object: ```Geocoder\Model\AddressCollection```,
which is itself composed of ```Geocoder\Model\Address```.

You can transform those objects into arrays. Example:

```php
$plugins = array('geonames', 'googlemaps', 'bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';
$options = array(
  'geonames' => array(), // array of options
  'googlemaps' => array(), // array of options
  'bingmaps' => array(), // array of options
);

$addressCollection = \Drupal::service('geocoder')->geocode($address, $plugins, $options);
$address_array = $addressCollection->first()->toArray();

// You can play a bit more with the API

$addressCollection = \Drupal::service('geocoder')->geocode($address, $plugins, $options);
$latitude = $addressCollection->first()->getCoordinates()->getLatitude();
$longitude = $addressCollection->first()->getCoordinates()->getLongitude();
```

You can also convert these to different formats using the Dumper plugins.
Get the list of available Dumper by doing:

```php
\Drupal::service('plugin.manager.geocoder.dumper')->getDefinitions();
```

Here's an example on how to use a Dumper

```php
$plugins = array('geonames', 'googlemaps', 'bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';

$addressCollection = \Drupal::service('geocoder')->geocode($address, $plugins);
$geojson = \Drupal::service('plugin.manager.geocoder.dumper')->createInstance('geojson')->dump($addressCollection->first());
```

There's also a dumper for GeoPHP, here's how to use it

```php
$plugins = array('geonames', 'googlemaps', 'bingmaps');
$address = '1600 Amphitheatre Parkway Mountain View, CA 94043';

$addressCollection = \Drupal::service('geocoder')->geocode($address, $plugins);
$geometry = \Drupal::service('plugin.manager.geocoder.dumper')->createInstance('geometry')->dump($addressCollection->first());
```

# Links
* [Composer](https://getcomposer.org/)
* [Drush](http://drush.org)
* [Geocoder PHP library](http://geocoder-php.org/)
* [Geocoder module](https://www.drupal.org/project/geocoder)

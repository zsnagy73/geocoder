# Geocoder 8.x-2.x

This is a complete rewrite of the Geocoder module, based on the
[Geocoder PHP library](http://geocoder-php.org)

# Features
* Solid API based on [Geocoder PHP library](href="http://geocoder-php.org);
* Geocode and Reverse Geocode using one or multiple Geocoder providers (ArcGISOnline, BingMaps, File, GoogleMaps, MapQuest, Nominatim, OpeneStreetMap, etc);
* Results can be dumped into multiple formats such as WKT, GeoJson, etc ...</li>
* The Geocoder Provider and Dumper plugins are extendable through a custom module;</li>
* Submodule Geocoder Field provides Drupal fields widgets and formatters, with even more options;</li>
* [Geofield](https://www.drupal.org/project/geofield) and [Address](https://www.drupal.org/project/address) fields integration.
* Caching results capabilities, enabled by default;

# Requirements
* [Composer](https://getcomposer.org/), to add the module to your codebase (for more info refer to [Using Composer to manage Drupal site dependencies](https://www.drupal.org/node/2718229);
* [Drush](http://drush.org), to enable the module (and its dependencies) from the shell;
* No other external requirements for the main geocoder Module: the [Geocoder PHP library](http://geocoder-php.org) will be downloaded automatically via composer (see below);
* The embedded "Geocoder Geofield" submodule requires the [Geofield Module](https://www.drupal.org/project/geofield);
* The embedded "Geocoder Address" submodule requires the [Address Module](https://www.drupal.org/project/address);

# Installation
* Download the module running the following shell command from you project root (at the composer.json file level):  
  ```$ composer require drupal/geocoder```  
  **Note:** this will also download the Geocoder PHP library as vendor/willdurand/geocoder
* Enable the module via [Drush](http://drush.org)  
 ```$ drush en geocoder```  
 or the website back-end/administration interface.
* Eventually enable also the submodules: ```geocoder_field``` and ```geocoder_geofield``` / ```geocoder_address```.

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

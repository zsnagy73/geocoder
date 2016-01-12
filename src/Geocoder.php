<?php

namespace Drupal\geocoder;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;

class Geocoder {

  /* @var GeocoderProviderInterface $plugin */
  protected static $plugin;

  public static function geocode($plugin = 'GoogleMaps', $data, $options = array()) {
    if (!isset(self::$plugin)) {
      self::setPlugin($plugin, $options);
    }

    return self::getPlugin()->setConfiguration($options)->geocode($data);
  }

  public static function reverse($plugin = 'GoogleMaps', $latitude, $longitude, $options = array()) {
    if (!isset(self::$plugin)) {
      self::setPlugin($plugin, $options);
    }

    return self::getPlugin()->setConfiguration($options)->reverse($latitude, $longitude);
  }

  /**
   * Set the Geocoder Provider plugin to use.
   *
   * @param string $plugin
   *   The Plugin ID to use.
   */
  public static function setPlugin($plugin = 'GoogleMaps', $configuration = array()) {
    self::$plugin = \Drupal::service('geocoder.Provider')->createInstance($plugin, $configuration);
  }

  /**
   * Return the Geocoder Provider plugin object.
   *
   * @return GeocoderProvider
   *   The Geocoder Provider plugin object.
   */
  public static function getPlugin() {
    return self::$plugin;
  }

}
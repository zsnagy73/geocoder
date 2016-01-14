<?php

namespace Drupal\geocoder;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Exception\InvalidCredentials;

class Geocoder {

  /* @var GeocoderProviderInterface $plugin */
  protected static $plugin;

  /**
   * @param string|array $plugins
   * @param $data
   * @param array $options
   *
   * @return \Geocoder\Model\AddressCollection
   */
  public static function geocode($plugins = array('GoogleMaps'), $data, array $options = array()) {
    foreach ((array) $plugins as $plugin) {
      $options += array($plugin => array());
      self::setPlugin($plugin, $options);

      try {
        return self::getPlugin()->geocode($data);
      } catch (InvalidCredentials $e) {
        self::log($e->getMessage(), 'error');
      } catch (\Exception $e) {
        self::log($e->getMessage(), 'error');
      }
    }

   $exception = new \Exception(sprintf('No plugin could geocode: "%s".', $data));
    self::log($exception->getMessage(), 'error');

    return FALSE;
  }

  /**
   * @param string|string[] $plugins
   * @param $data
   * @param array $options
   *
   * @return \Geocoder\Model\AddressCollection
   */
  public static function reverse($plugins = 'GoogleMaps', $latitude, $longitude, array $options = array()) {
    foreach ((array) $plugins as $plugin) {
      $plugin_options = isset($options[$plugin]) ? $options[$plugin] : array();
      self::setPlugin($plugin, $plugin_options);

      try {
        return self::getPlugin()->reverse($latitude, $longitude);
      } catch (InvalidCredentials $e) {
        self::log($e->getMessage(), 'error');
      } catch (\Exception $e) {
        self::log($e->getMessage(), 'error');
      }
    }

    $exception = new \Exception(sprintf('No plugin could reverse geocode: "%s %s".', $latitude, $longitude));
    self::log($exception->getMessage(), 'error');

    return FALSE;
  }

  /**
   * Set the Geocoder Provider plugin to use.
   *
   * @param string $plugin
   *   The Plugin ID to use.
   */
  public static function setPlugin($plugin = 'GoogleMaps', array $configuration = array()) {
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

  /**
   * Gets a list of available plugins.
   *
   * @return string[]
   *   The Geocoder plugins available.
   */
  public static function getPlugins() {
    $options = array();
    foreach (\Drupal::service('geocoder.Provider')->getDefinitions() as $data) {
      $name = isset($data['label']) ? $data['label'] : $data['id'];
      $options['geocoder:' . $data['id']] = $name;
    }
    asort($options);
    return $options;
  }

  /**
   * Log a message in the Drupal watchdog and on screen.
   *
   * @param $message
   *   The message
   * @param $type
   *   The type of message
   */
  public static function log($message, $type) {
    \Drupal::service('logger.dblog')->log($type, $message, array('channel' => 'geocoder'));
    \Drupal::service('messenger')->addMessage($message, $type);
  }

}

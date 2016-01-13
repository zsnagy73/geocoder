<?php
/**
 * @file
 * Class Config.
 */

namespace Drupal\geocoder;

/**
 * Class Config.
 */
class Config {

  /**
   * Get default configuration.
   *
   * @param string $key
   *   Key to get. If not provided, returns the full array.
   *
   * @return array|null
   *   Returns the array or if a key is provided, it's value.
   */
  static protected function defaults($key = NULL) {
    $defaults = array(
      'geocoder.cache' => TRUE,
    );
    if ($key == NULL) {
      return $defaults;
    }

    return isset($defaults[$key]) ? $defaults[$key] : NULL;
  }

  /**
   * Fetches a configuration value.
   *
   * @param string|array $parents
   *   The path to the configuration value. Strings use dots as path separator.
   * @param string|array $default_value
   *   The default value to use if the config value isn't set.
   *
   * @return mixed
   *   The configuration value.
   */
  static public function get($parents, $default_value = NULL) {
    $options = \Drupal::service('variable')->get('geocoder_config', array());

    if (is_string($parents)) {
      $parents = explode('.', $parents);
    }

    if (is_array($parents)) {
      $notfound = FALSE;
      foreach ($parents as $parent) {
        if (array_key_exists($parent, $options)) {
          $options = $options[$parent];
        }
        else {
          $notfound = TRUE;
          break;
        }
      }
      if (!$notfound) {
        return $options;
      }
    }

    $value = Config::defaults(implode('.', $parents));
    if (isset($value)) {
      return $value;
    }

    if (is_null($default_value)) {
      return FALSE;
    }

    return $default_value;
  }

  /**
   * Sets a configuration value.
   *
   * @param string|array $parents
   *   The path to the configuration value. Strings use dots as path separator.
   * @param mixed $value
   *   The  value to set.
   *
   * @return array
   *   The configuration array.
   */
  static public function set($parents, $value) {
    $config = \Drupal::service('variable')->get('geocoder_config', array());

    if (is_string($parents)) {
      $parents = explode('.', $parents);
    }

    $ref = &$config;
    foreach ($parents as $parent) {
      if (isset($ref) && !is_array($ref)) {
        $ref = array();
      }
      $ref = &$ref[$parent];
    }
    $ref = $value;

    \Drupal::service('variable')->set('geocoder_config', $config);
    return $config;
  }

  /**
   * Removes a configuration value.
   *
   * @param string|array $parents
   *   The path to the configuration value. Strings use dots as path separator.
   *
   * @return array
   *   The configuration array.
   */
  static public function clear($parents) {
    $config = \Drupal::service('variable')->get('geocoder_config', array());
    $ref = &$config;

    if (is_string($parents)) {
      $parents = explode('.', $parents);
    }

    $last = end($parents);
    reset($parents);
    foreach ($parents as $parent) {
      if (isset($ref) && !is_array($ref)) {
        $ref = array();
      }
      if ($last == $parent) {
        unset($ref[$parent]);
      }
      else {
        if (isset($ref[$parent])) {
          $ref = &$ref[$parent];
        }
        else {
          break;
        }
      }
    }
    \Drupal::service('variable')->set('geocoder_config', $config);
    return $config;
  }

}

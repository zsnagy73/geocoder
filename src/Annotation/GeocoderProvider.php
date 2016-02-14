<?php

/**
 * @file
 * Contains \Drupal\geocoder\Annotation\GeocoderProvider.
 */

namespace Drupal\geocoder\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a geocoder provider plugin annotation object.
 *
 * @Annotation
 */
class GeocoderProvider extends GeocoderPluginBase {

  /**
   * Handler arguments names.
   *
   * Plugin annotations can define each item in the array either as key-value
   * pair or as simple array item. When the argument name is in the key, the
   * value will contain the default value to be used if the plugin instance
   * didn't provide a value.
   *
   * @var array (optional)
   */
  public $arguments = [];

}

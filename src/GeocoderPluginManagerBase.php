<?php

namespace Drupal\geocoder;

use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Provides a base class for geocoder plugin managers.
 */
abstract class GeocoderPluginManagerBase extends DefaultPluginManager {

  /**
   * List of fields types available as source for Geocode operations.
   *
   * @var array
   */
  protected $geocodeSourceFieldsTypes = [
    "string",
    "string_long",
    "text",
    "text_long",
    "address",
  ];

  /**
   * List of fields types available as source for Reverse Geocode operations.
   *
   * @var array
   */
  protected $reverseGeocodeSourceFieldsTypes = [
    "geofield",
  ];

  /**
   * Gets a list of available plugins to be used in forms.
   *
   * @return string[]
   *   A list of plugins in a format suitable for form API '#options' key.
   */
  public function getPluginsAsOptions() {
    $options = array_map(function (array $definition) {
      return isset($definition['name']) ? $definition['name'] : $definition['id'];
    }, $this->getDefinitions());
    asort($options);

    return $options;
  }

  /**
   * Gets a list of fields types available for Geocode operations.
   *
   * @return string[]
   *   A list of plugins in a format suitable for form API '#options' key.
   */
  public function getGeocodeSourceFieldsTypes() {
    return $this->geocodeSourceFieldsTypes;
  }

  /**
   * Gets a list of fields types available for Reverse Geocode operations.
   *
   * @return string[]
   *   A list of plugins in a format suitable for form API '#options' key.
   */
  public function getReverseGeocodeSourceFieldsTypes() {
    return $this->reverseGeocodeSourceFieldsTypes;
  }

}

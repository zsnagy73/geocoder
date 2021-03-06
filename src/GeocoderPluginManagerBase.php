<?php

namespace Drupal\geocoder;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Component\Serialization\Json;

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
    return array_map(function ($plugin) {
      return $plugin['name'];
    }, $this->getPlugins());
  }

  /**
   * Return the array of plugins and their settings if any.
   *
   * @return array
   *   A list of plugins with their settings.
   */
  public function getPlugins() {
    $config = \Drupal::config('geocoder.settings');
    $plugins_options = Json::decode($config->get('plugins_options'));

    $options = array_map(function (array $definition) use ($plugins_options) {
      $plugins_options += [$definition['id'] => []];
      $definition += ['name' => $definition['id'], 'arguments' => []];

      return [
        'id' => $definition['id'],
        'name' => $definition['name'],
        'settings' => array_merge($definition['arguments'], $plugins_options[$definition['id']]),
      ];
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

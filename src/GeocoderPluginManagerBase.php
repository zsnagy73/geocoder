<?php

namespace Drupal\geocoder;

use Drupal\Component\Serialization\Json;
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

    $plugins_arguments = $config->get('plugins_options');

    // Convert old JSON config.
    // This should be removed before the stable release 8.x-2.0.
    if (is_string($plugins_arguments) && $json = Json::decode($plugins_arguments)) {
      // Convert each plugins property in lowercase.
      $plugins_arguments = array_map(function ($old_plugin_arguments) {
        return array_combine(
          array_map(function ($k) {
            return strtolower($k);
          }, array_keys($old_plugin_arguments)),
          $old_plugin_arguments
        );
      }, $json);
    }

    $plugins_arguments = (array) $plugins_arguments;

    $definitions = array_map(function (array $definition) use ($plugins_arguments) {
      $plugins_arguments += [$definition['id'] => []];
      $definition += ['name' => $definition['id']];
      $definition['arguments'] = array_merge($definition['arguments'], $plugins_arguments[$definition['id']]);

      return $definition;
    }, $this->getDefinitions());

    ksort($definitions);

    return $definitions;
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

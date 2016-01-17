<?php

namespace Drupal\geocoder;

use Drupal\Component\Plugin\Exception\PluginException;
use Drupal\geocoder\Plugin\Geocoder\DumperInterface;
use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Drupal\service_container\Plugin\ContainerAwarePluginManager;
use Geocoder\Exception\InvalidCredentials;

class Geocoder {
  /**
   * @var ContainerAwarePluginManager;
   */
  private static $manager;

  /**
   * Geocode a string.
   *
   * @param string|string[] $plugins
   *   The name of the plugin to use or a list of plugins names to use.
   * @param $data
   *   The string to geocode.
   * @param array $options (optional)
   *   The plugin options.
   *
   * @return \Geocoder\Model\AddressCollection|FALSE
   */
  public static function geocode($plugins = array('googlemaps'), $data, array $options = array()) {
    foreach ((array) $plugins as $plugin) {
      $plugin = drupal_strtolower($plugin);
      $plugin_options = isset($options[$plugin]) ? $options[$plugin] : array();
      $plugin = self::getPlugin('Provider', $plugin, $plugin_options);

      try {
        return $plugin->geocode($data);
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
   * Reverse geocode coordinates.
   *
   * @param string|string[] $plugins
   *   The name of the plugin to use or a list of plugins names to use.
   * @param double $latitude
   *   The latitude.
   * @param double $longitude
   *   The longitude.
   * @param array $options (optional)
   *   The plugin options.
   *
   * @return \Geocoder\Model\AddressCollection|FALSE
   */
  public static function reverse($plugins = 'googlemaps', $latitude, $longitude, array $options = array()) {
    foreach ((array) $plugins as $plugin) {
      $plugin_options = isset($options[$plugin]) ? $options[$plugin] : array();
      $plugin = self::getPlugin('Provider', $plugin, $plugin_options);

      try {
        return $plugin->reverse($latitude, $longitude);
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
   * Return a Geocoder plugin object.
   *
   * @param string $type
   *   The type of plugin to return.
   * @param string $plugin
   *   The plugin id to return.
   * @param array $options (optional)
   *   The plugin options.
   *
   * @return DumperInterface|ProviderInterface
   *   The Geocoder plugin object.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public static function getPlugin($type, $plugin, array $options = array()) {
    $manager = self::getPluginManager();

    if ($manager->hasDefinition($plugin)) {
      if ($definition = $manager->getDefinition($plugin)) {
        if ($definition['type'] == $type) {
          return $manager->createInstance($plugin, $options);
        } else {
          throw new PluginException(t('Geocoder plugin type not found. (@type, @plugin_id)', array('@type' => $type, '@plugin_id' => $plugin)));
        }
      }
    }
  }

  /**
   * Return the plugin manager.
   *
   * @return ContainerAwarePluginManager
   *   The plugin manager.
   */
  public static function getPluginManager() {
    if (self::$manager) {
      return self::$manager;
    }
    self::setPluginManager(\Drupal::service('plugin.manager.geocoder'));

    return self::getPluginManager();
  }

  /**
   * Return the plugin manager.
   *
   * @param ContainerAwarePluginManager $manager
   *   The container plugin manager.
   */
  public static function setPluginManager(ContainerAwarePluginManager $manager) {
    self::$manager = $manager;
  }

  /**
   * Gets a list of available plugins.
   *
   * @param string $type
   *   The plugin type.
   *
   * @return string[]
   *   The Geocoder plugin type.
   */
  public static function getPlugins($type = NULL) {
    $options = array();

    foreach (self::getPluginManager()->getDefinitions() as $data) {
      $name = isset($data['name']) ? $data['name'] : $data['id'];
      $options[$data['type']][$data['id']] = $name;
    }
    asort($options);

    return isset($options[$type]) ? $options[$type] : $options;
  }

  /**
   * Log a message in the Drupal watchdog and on screen.
   *
   * @param string $message
   *   The message
   * @param string $type
   *   The type of message
   */
  public static function log($message, $type) {
    \Drupal::service('logger.dblog')->log($type, $message, array('channel' => 'geocoder'));
    \Drupal::service('messenger')->addMessage($message, $type);
  }

}

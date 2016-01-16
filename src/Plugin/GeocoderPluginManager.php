<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\GeocoderPluginManager.
 */

namespace Drupal\geocoder\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Ivory\HttpAdapter\HttpAdapterInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * Plugin type manager for all geocoder plugins.
 */
class GeocoderPluginManager extends DefaultPluginManager {

  /**
   * Constructs a ViewsPluginManager object.
   *
   * @param string $type
   *   The plugin type, for example filter.
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations,
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct($type, \Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler, HttpAdapterInterface $adapter) {
    $plugin_definition_annotation_name = 'Drupal\geocoder\Annotation\GeocoderPlugin';
    parent::__construct('Plugin/Geocoder/'. Container::camelize($type), $namespaces, $module_handler, 'Drupal\geocoder\Plugin\GeocoderPluginInterface', $plugin_definition_annotation_name);

    $this->defaults += array(
      'plugin_type' => strtolower($type),
    );

    $this->alterInfo('geocoder_plugins_' . $type);
    $this->setCacheBackend($cache_backend, 'geocoder:' . $type);
  }

}

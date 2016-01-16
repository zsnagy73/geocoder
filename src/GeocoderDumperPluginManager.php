<?php

/**
 * @file
 * Contains \Drupal\geocoder\GeocoderDumperPluginManager.
 */

namespace Drupal\geocoder;

use Drupal\Component\Plugin\FallbackPluginManagerInterface;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\CategorizingPluginManagerTrait;
use Drupal\Core\Plugin\Context\ContextAwarePluginManagerTrait;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Manages discovery and instantiation of block plugins.
 */
class GeocoderDumperPluginManager extends DefaultPluginManager {

  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/Geocoder', $namespaces, $module_handler, 'Drupal\geocoder\GeocoderDumperInterface', 'Drupal\geocoder\Component\Annotation\GeocoderDumperPlugin');

    $this->alterInfo('geocoder.dumper');
    $this->setCacheBackend($cache_backend, 'geocoder_dumper_plugins');
  }

}

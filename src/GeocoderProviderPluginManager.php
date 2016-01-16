<?php

/**
 * @file
 * Contains \Drupal\geocoder\GeocoderProviderPluginManager.
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
class GeocoderProviderPluginManager extends DefaultPluginManager {

  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/Geocoder', $namespaces, $module_handler, 'Drupal\geocoder\GeocoderProviderInterface', 'Drupal\geocoder\Component\Annotation\GeocoderProviderPlugin');

    $this->alterInfo('geocoder.provider');
    $this->setCacheBackend($cache_backend, 'geocoder_provider_plugins');
  }

}

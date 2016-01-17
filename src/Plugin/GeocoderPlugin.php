<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\GeocoderPlugin.
 */

namespace Drupal\geocoder\Plugin;

use Drupal\Component\Plugin\PluginBase;
use Drupal\geocoder\Config;

class GeocoderPlugin extends PluginBase implements GeocoderPluginInterface {
  /**
   * GeocoderPlugin constructor.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   */
  public function __construct($configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->init();
  }

  /**
   * {@inheritdoc}
   */
  public function init() {
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration = array()) {
    if (!empty($configuration)) {
      $this->configuration = $configuration;
    }

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function cache_get($cid) {
    if ((bool) Config::get('geocoder.cache', TRUE)) {
      if ($cache = cache_get($cid, 'cache_geocoder')) {
        return $cache->data;
      }
    }

    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function cache_set($cid, $data) {
    if ((bool) Config::get('geocoder.cache', TRUE)) {
      cache_set($cid, $data, 'cache_geocoder', CACHE_PERMANENT);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheCid() {
    $args = func_get_args();

    $args[] = $this->getPluginId();
    $args[] = $this->getConfiguration();

    return sha1(serialize(array_filter($args)));
  }

}

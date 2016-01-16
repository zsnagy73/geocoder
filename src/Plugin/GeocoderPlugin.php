<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\GeocoderPlugin.
 */

namespace Drupal\geocoder\Plugin;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Component\Plugin\PluginInspectionInterface;

class GeocoderPlugin extends Pluginbase implements GeocoderPluginInterface, PluginInspectionInterface {
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

}

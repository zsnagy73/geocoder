<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\GeocoderPlugin.
 */

namespace Drupal\geocoder\Plugin;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

class GeocoderPlugin extends Pluginbase implements GeocoderPluginInterface, PluginInspectionInterface {
  /**
   * @var ModuleHandlerInterface
   */
  private $module_handler;

  /**
   * GeocoderPlugin constructor.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   */
  public function __construct($configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->module_handler = \Drupal::service('module_handler');
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
   * Set the module handler.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *
   * @return GeocoderPluginInterface
   */
  public function setModuleHandler(ModuleHandlerInterface $module_handler) {
    $this->module_handler = $module_handler;

    return $this;
  }

  /**
   * Get the module handler.
   *
   * @return \Drupal\Core\Extension\ModuleHandlerInterface
   */
  public function getModuleHandler() {
    return $this->module_handler;
  }

}

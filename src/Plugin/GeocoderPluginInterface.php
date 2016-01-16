<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\GeocoderPluginInterface.
 */

namespace Drupal\geocoder\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;

interface GeocoderPluginInterface extends PluginInspectionInterface {
  /**
   * Init method launched after object initialization.
   */
  public function init();

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration = array());

  /**
   * {@inheritdoc}
   */
  public function getConfiguration();

}

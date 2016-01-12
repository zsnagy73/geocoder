<?php

namespace Drupal\geocoder\GeocoderProvider;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\geocoder\GeocoderProviderInterface;
use Geocoder\Model\AddressCollection;
use Geocoder\Provider\AbstractHttpProvider;
use Geocoder\Provider\Provider;
use Ivory\HttpAdapter\HttpAdapterInterface;

class GeocoderProvider extends AbstractHttpProvider implements PluginInspectionInterface, GeocoderProviderInterface {

  /**
   * A string which is used to separate base plugin IDs from the derivative ID.
   */
  const DERIVATIVE_SEPARATOR = ':';

  /**
   * The plugin_id.
   *
   * @var string
   */
  protected $pluginId;

  /**
   * The plugin implementation definition.
   *
   * @var array
   */
  protected $pluginDefinition;

  /**
   * Configuration information passed into the plugin.
   *
   * When using an interface like
   * \Drupal\Component\Plugin\ConfigurablePluginInterface, this is where the
   * configuration should be stored.
   *
   * Plugin configuration is optional, so plugin implementations must provide
   * their own setters and getters.
   *
   * @var array
   */
  protected $configuration;

  /**
   * @var Provider;
   */
  private $handler;

  public function __construct($configuration, $plugin_id, $plugin_definition, HttpAdapterInterface $adapter) {
    $this->configuration = $configuration;
    $this->pluginId = $plugin_id;
    $this->pluginDefinition = $plugin_definition;
    parent::__construct($adapter);
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
  public function getPluginId() {
    return $this->pluginId;
  }

  /**
   * {@inheritdoc}
   */
  public function getBaseId() {
    $plugin_id = $this->getPluginId();
    if (strpos($plugin_id, static::DERIVATIVE_SEPARATOR)) {
      list($plugin_id) = explode(static::DERIVATIVE_SEPARATOR, $plugin_id, 2);
    }
    return $plugin_id;
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginDefinition() {
    return $this->pluginDefinition;
  }

  /**
   * {@inheritdoc}
   */
  public function setHandler($handler) {
    $this->handler = $handler;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getHandler() {
    return $this->handler;
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration($configuration = array()) {
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
   * Geocode a string
   *
   * @param string $data
   *   The string to geocode
   *
   * @return AddressCollection
   */
  public function geocode($data) {
    return $this->getHandler()->geocode($data);
  }

  /**
   * Reverse geocode a string
   *
   * @param string $latitude
   *   The latitude
   * @param string $longitude
   *   The longitude
   *
   * @return AddressCollection
   */
  public function reverse($latitude, $longitude) {
    return $this->getHandler()->reverse($latitude, $longitude);
  }

}
<?php

namespace Drupal\geocoder;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Model\AddressCollection;
use Geocoder\Provider\Provider;

interface GeocoderProviderInterface {

  /**
   * Initialize the geocoder and set the handler.
   *
   * @return GeocoderProvider
   */
  public function init();

  /**
   * {@inheritdoc}
   */
  public function getPluginId();

  /**
   * {@inheritdoc}
   */
  public function getBaseId();

  /**
   * {@inheritdoc}
   */
  public function getPluginDefinition();

  /**
   * Set the Geocoder handler to use.
   *
   * @param string $handler
   *   The Geocoder name.
   *
   * @return GeocoderProvider
   */
  public function setHandler($handler);

  /**
   * Get the Geocoder handler in use.
   *
   * @return Provider
   */
  public function getHandler();

  /**
   * Set the configuration.
   *
   * @param array $configuration
   *   The configuration.
   *
   * @return GeocoderProvider
   */
  public function setConfiguration($configuration = array());

  /**
   * Get the configuration.
   *
   * @return array
   *   The configuration array.
   */
  public function getConfiguration();

  /**
   * Geocode a string
   *
   * @param string $data
   *   The string to geocode
   *
   * @return AddressCollection
   */
  public function geocode($data);

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
  public function reverse($latitude, $longitude);

}
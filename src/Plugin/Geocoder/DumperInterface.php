<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\Geocoder\DumperInterface.
 */

namespace Drupal\geocoder\Plugin\Geocoder;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\geocoder\Plugin\GeocoderPluginInterface;
use Geocoder\Model\Address;

interface DumperInterface extends GeocoderPluginInterface, ContainerFactoryPluginInterface {
  /**
   * Dump the argument into a specific format.
   */
  public function dump(Address $address);

  /**
   * Set the Geocoder dumper to use.
   */
  public function setGeocoderDumper(\Geocoder\Dumper\Dumper $dumper);

  /**
   * Get the Geocoder dumper in use.
   */
  public function getGeocoderDumper();

}
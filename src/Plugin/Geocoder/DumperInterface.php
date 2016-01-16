<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\Geocoder\DumperInterface.
 */

namespace Drupal\geocoder\Plugin\Geocoder;

use Drupal\geocoder\Plugin\GeocoderPluginInterface;
use Geocoder\Model\Address;

interface DumperInterface extends GeocoderPluginInterface {
  /**
   * Dump the argument into a specific format.
   */
  public function dump(Address $address);

}
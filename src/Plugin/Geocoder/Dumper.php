<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\Geocoder\Dumper.
 */

namespace Drupal\geocoder\Plugin\Geocoder;

use Drupal\geocoder\Plugin\GeocoderPlugin;
use Geocoder\Model\Address;

class Dumper extends GeocoderPlugin implements DumperInterface {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {}

}

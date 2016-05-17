<?php

/**
 * @file
 * Contains \Drupal\geocoder_geofield\Plugin\Geocoder\Dumper\Geohash.
 */

namespace Drupal\geocoder_geofield\Plugin\Geocoder\Dumper;

use Geocoder\Model\Address;

class Geohash extends Geometry {

  /**
   * {@inheritdoc}
   */
  public function dump(Address $address) {
    return parent::dump($address)->out('geohash');
  }

}

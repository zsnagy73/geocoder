<?php

/**
 * @file
 * Contains \Drupal\geocoder_geofield\Plugin\Geocoder\Dumper\Geohash.
 */

namespace Drupal\geocoder_geofield\Plugin\Geocoder\Dumper;

use Geocoder\Model\Address;

/**
 * Provides a Geohash geocoder dumper plugin.
 *
 * @GeocoderDumper(
 *   id = "geohash",
 *   name = "Geohash",
 *   handler = "\Geocoder\Dumper\GeoJson"
 * )
 */
class Geohash extends Geometry {

  /**
   * {@inheritdoc}
   */
  public function dump(Address $address) {
    return $this->geophp->load($this->getHandler()->dump($address), 'json')->out('geohash');
  }

}

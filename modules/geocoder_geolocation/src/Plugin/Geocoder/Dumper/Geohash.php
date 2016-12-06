<?php

namespace Drupal\geocoder_geolocation\Plugin\Geocoder\Dumper;

use Drupal\geocoder\DumperBase;
use Geocoder\Model\Address;

/**
 * Provides a geohash geocoder dumper plugin.
 *
 * @GeocoderDumper(
 *   id = "geohash",
 *   name = "Geohash",
 *   handler = "\Drupal\geocoder_geolocation\Geocoder\Dumper\Geometry"
 * )
 */
class Geohash extends DumperBase {

  /**
   * {@inheritdoc}
   */
  public function dump(Address $address) {
    return parent::dump($address)->out('geohash');
  }

}

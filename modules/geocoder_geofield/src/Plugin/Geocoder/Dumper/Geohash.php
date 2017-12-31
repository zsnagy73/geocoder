<?php

namespace Drupal\geocoder_geofield\Plugin\Geocoder\Dumper;

use Drupal\geocoder\DumperBase;
use Geocoder\Model\Address;

/**
 * Provides a geohash geocoder dumper plugin.
 *
 * @GeocoderDumper(
 *   id = "geohash",
 *   name = "Geohash",
 *   handler = "\Drupal\geocoder_geofield\Geocoder\Dumper\Geometry"
 * )
 */
class Geohash extends DumperBase {

  /**
   * {@inheritdoc}
   */
  public function dump(Address $address) {
    /* @var \Geometry $geometry */
    $geometry = parent::dump($address);
    return $geometry->out('geohash');
  }

}

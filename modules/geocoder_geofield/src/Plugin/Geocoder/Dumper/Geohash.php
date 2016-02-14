<?php

/**
 * @file
 * Contains \Drupal\geocoder_geofield\Plugin\Geocoder\Dumper\Geohash.
 */

namespace Drupal\geocoder_geofield\Plugin\Geocoder\Dumper;

use Drupal\geocoder\Plugin\Geocoder\Dumper\GeoJson;
use Drupal\geophp\GeoPHPInterface;
use Geocoder\Model\Address;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
    return parent::dump($address)->out('geohash');
  }

}

<?php
/**
 * @file
 * The Geometry plugin.
 */

namespace Drupal\geocoder\Plugin\GeocoderDumper;

use Drupal\geocoder\GeocoderDumper;
use Drupal\geocoder\GeocoderDumperInterface;
use Geocoder\Model\Address;

/**
 * Class Geometry.
 *
 * @GeocoderDumperPlugin(
 *  id = "geometry",
 * )
 */
class Geometry extends GeocoderDumper implements GeocoderDumperInterface {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $handler = new \Geocoder\Dumper\Geometry();
    return $handler->dump($address);
  }

}

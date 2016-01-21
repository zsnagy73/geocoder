<?php
/**
 * @file
 * The Geometry plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Dumper;

use Drupal\geocoder\Plugin\Geocoder\Dumper;
use Drupal\geocoder\Plugin\Geocoder\DumperInterface;
use Geocoder\Model\Address;

/**
 * Class Geometry.
 *
 * @GeocoderPlugin(
 *  id = "geometry",
 *  name = "Geometry"
 * )
 */
class Geometry extends Dumper implements DumperInterface {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $handler = new \Drupal\geocoder\Geocoder\Dumper\Geometry();
    return $handler->dump($address);
  }

}

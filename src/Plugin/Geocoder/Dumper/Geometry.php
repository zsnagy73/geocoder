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
 *  name = "Geometry",
 *  type = "Dumper"
 * )
 */
class Geometry extends Dumper implements DumperInterface {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $handler = new \Geocoder\Dumper\Geometry();
    return $handler->dump($address);
  }

}

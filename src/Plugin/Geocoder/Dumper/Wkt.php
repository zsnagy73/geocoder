<?php
/**
 * @file
 * The Wkt plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Dumper;

use Drupal\geocoder\Plugin\Geocoder\Dumper;
use Drupal\geocoder\Plugin\Geocoder\DumperInterface;
use Geocoder\Model\Address;

/**
 * Class Wkt.
 *
 * @GeocoderPlugin(
 *  id = "wkt",
 *  name = "WKT"
 * )
 */
class Wkt extends Dumper implements DumperInterface {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $handler = new \Geocoder\Dumper\Wkt();
    return $handler->dump($address);
  }

}

<?php
/**
 * @file
 * The Gpx plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Dumper;

use Drupal\geocoder\Plugin\Geocoder\Dumper;
use Drupal\geocoder\Plugin\Geocoder\DumperInterface;
use Geocoder\Model\Address;

/**
 * Class Gpx.
 *
 * @GeocoderPlugin(
 *  id = "gpx",
 *  name = "GPX"
 * )
 */
class Gpx extends Dumper implements DumperInterface {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $handler = new \Geocoder\Dumper\Gpx();
    return $handler->dump($address);
  }

}

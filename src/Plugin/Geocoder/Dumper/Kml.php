<?php
/**
 * @file
 * The Kml plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Dumper;

use Drupal\geocoder\Plugin\Geocoder\Dumper;
use Drupal\geocoder\Plugin\Geocoder\DumperInterface;
use Geocoder\Model\Address;

/**
 * Class Kml.
 *
 * @GeocoderPlugin(
 *  id = "kml",
 *  name = "KML"
 * )
 */
class Kml extends Dumper implements DumperInterface {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $handler = new \Geocoder\Dumper\Kml();
    return $handler->dump($address);
  }

}

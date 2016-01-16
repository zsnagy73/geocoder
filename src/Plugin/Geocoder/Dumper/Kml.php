<?php
/**
 * @file
 * The Kml plugin.
 */

namespace Drupal\geocoder\Plugin\Dumper;

use Drupal\geocoder\GeocoderDumper;
use Drupal\geocoder\GeocoderDumperInterface;
use Geocoder\Model\Address;

/**
 * Class Kml.
 *
 * @GeocoderDumperPlugin(
 *  id = "kml",
 *  name = "KML"
 * )
 */
class Kml extends GeocoderDumper implements GeocoderDumperInterface {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $handler = new \Geocoder\Dumper\Kml();
    return $handler->dump($address);
  }

}

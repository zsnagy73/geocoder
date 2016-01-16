<?php
/**
 * @file
 * The Gpx plugin.
 */

namespace Drupal\geocoder\Plugin\Dumper;

use Drupal\geocoder\GeocoderDumper;
use Drupal\geocoder\GeocoderDumperInterface;
use Geocoder\Model\Address;

/**
 * Class Gpx.
 *
 * @GeocoderDumperPlugin(
 *  id = "gpx",
 *  name = "GPX"
 * )
 */
class Gpx extends GeocoderDumper implements GeocoderDumperInterface {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $handler = new \Geocoder\Dumper\Gpx();
    return $handler->dump($address);
  }

}

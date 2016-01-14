<?php
/**
 * @file
 * The GeoJson plugin.
 */

namespace Drupal\geocoder\Plugin\GeocoderDumper;

use Drupal\geocoder\GeocoderDumper;
use Drupal\geocoder\GeocoderDumperInterface;
use Geocoder\Model\Address;

/**
 * Class GeoJson.
 *
 * @GeocoderDumperPlugin(
 *  id = "geojson",
 * )
 */
class GeoJson extends GeocoderDumper implements GeocoderDumperInterface {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $handler = new \Geocoder\Dumper\GeoJson();
    return $handler->dump($address);
  }

}

<?php
/**
 * @file
 * The Geohash plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Dumper;

use Drupal\geocoder\Plugin\Geocoder\DumperInterface;
use Drupal\geocoder\Plugin\Geocoder\Dumper;
use Geocoder\Model\Address;

/**
 * Class Geohash.
 *
 * @GeocoderPlugin(
 *  id = "geohash",
 *  name = "Geohash"
 * )
 */
class Geohash extends GeoJson implements DumperInterface {
  /**
   * @inheritDoc
   */
  public function dump(Address $address) {
    return \geoPHP::load(parent::dump($address), 'json')->out('geohash');
  }

}

<?php
/**
 * @file
 * The Wkb plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Dumper;

use Drupal\geocoder\Plugin\Geocoder\Dumper;
use Drupal\geocoder\Plugin\Geocoder\DumperInterface;
use Geocoder\Model\Address;

/**
 * Class Wkb.
 *
 * @GeocoderPlugin(
 *  id = "wkb",
 *  name = "WKB",
 *  type = "Dumper"
 * )
 */
class Wkb extends Dumper implements DumperInterface {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $handler = new \Geocoder\Dumper\Wkb();
    return $handler->dump($address);
  }

}

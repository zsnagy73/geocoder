<?php
/**
 * @file
 * The AddressText plugin.
 */

namespace Drupal\geocoder_address\Plugin\Geocoder\Dumper;

use Drupal\geocoder\Plugin\Geocoder\Dumper;
use Drupal\geocoder\Plugin\Geocoder\DumperInterface;
use Geocoder\Model\Address;

/**
 * Class AddressText.
 *
 * @GeocoderPlugin(
 *  id = "addresstext",
 *  name = "Address string"
 * )
 */
class AddressText extends Dumper implements DumperInterface {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $handler = new \Geocoder\Dumper\AddressText();
    return $handler->dump($address);
  }

}

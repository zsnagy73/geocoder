<?php

/**
 * @file
 * Contains \Drupal\geocoder_address\Plugin\Geocoder\Dumper\AddressText.
 */

namespace Drupal\geocoder_address\Plugin\Geocoder\Dumper;

use Drupal\Core\Plugin\PluginBase;
use Drupal\geocoder\DumperInterface;
use Geocoder\Model\Address;

/**
 * Provides an address string geocoder dumper plugin.
 *
 * @GeocoderDumper(
 *   id = "addresstext",
 *   name = "Address string"
 * )
 */
class AddressText extends PluginBase implements DumperInterface {

  /**
   * {@inheritdoc}
   */
  public function dump(Address $address) {
    $values = [];
    foreach ($address->toArray() as $key => $value) {
      if (!is_array($value)) {
        $values[$key] = $value;
      }
    }
    unset($values['latitude']);
    unset($values['longitude']);

    return implode(',', array_filter($values));
  }

}

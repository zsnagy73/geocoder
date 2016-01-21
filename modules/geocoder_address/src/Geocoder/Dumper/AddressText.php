<?php
/**
 * @file
 * The AddressText plugin.
 */

namespace Geocoder\Dumper;
use Geocoder\Model\Address;

/**
 * @author Pol Dellaiera <pol.dellaiera@gmail.com>
 */
class AddressText implements Dumper {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $values = array();
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

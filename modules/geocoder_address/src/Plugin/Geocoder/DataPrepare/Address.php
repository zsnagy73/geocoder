<?php
/**
 * @file
 * The Address Data Prepare plugin.
 */

namespace Drupal\geocoder_address\Plugin\Geocoder\DataPrepare;

use Drupal\geocoder\Plugin\Geocoder\DataPrepare;
use Drupal\geocoder\Plugin\Geocoder\InputFormat;
use Drupal\geocoder\Plugin\Geocoder\InputFormatInterface;
use Drupal\geocoder\Plugin\GeocoderPluginInterface;

/**
 * Class Address.
 *
 * @GeocoderPlugin(
 *  id = "data_prepare_address",
 *  name = "Address",
 *  field_types = {
 *     "address"
 *   }
 * )
 */
class Address extends DataPrepare implements GeocoderPluginInterface {
  /**
   * @inheritDoc
   */
  public function getPreparedValues() {
    $values = $this->getValues();

    foreach($values as $index => $value) {
      $address = array();
      $address[] = isset($value['address_line1']) ? $value['address_line1'] : NULL;
      $address[] = isset($value['address_line2']) ? $value['address_line2'] : NULL;
      $address[] = isset($value['postal_code']) ? $value['postal_code'] : NULL;
      $address[] = isset($value['locality']) ? $value['locality'] : NULL;
      $address[] = isset($value['country_code']) ? $value['country_code'] : NULL;

      $values[$index]['value'] = implode(',', array_filter($address));
    }

    return $values;
  }

}

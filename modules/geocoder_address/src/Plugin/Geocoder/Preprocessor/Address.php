<?php

/**
 * @file
 * Contains \Drupal\geocoder_address\Plugin\Geocoder\Preprocessor\Address.
 */

namespace Drupal\geocoder_address\Plugin\Geocoder\Preprocessor;

use Drupal\geocoder_field\PreprocessorBase;

/**
 * Provides a geocoder preprocessor plugin for address fields.
 *
 * @GeocoderPreprocessor(
 *   id = "address",
 *   name = "Address",
 *   field_types = {
 *     "address"
 *   }
 * )
 */
class Address extends PreprocessorBase {

  /**
   * {@inheritdoc}
   */
  public function preprocess() {
    parent::preprocess();

    $defaults = [
      'address_line1' => NULL,
      'address_line2' => NULL,
      'postal_code' => NULL,
      'locality' => NULL,
      'country_code' => NULL,
    ];
    foreach ($this->field->getValue() as $delta => $value) {
      $value += $defaults;
      $address = [
        $value['address_line1'],
        $value['address_line2'],
        $value['postal_code'],
        $value['locality'],
        $value['country_code']
      ];
      $value['value'] = implode(',', array_filter($address));
      $this->field->set($delta, $value);
    }

    return $this;
  }

}

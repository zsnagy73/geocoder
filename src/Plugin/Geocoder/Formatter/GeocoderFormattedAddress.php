<?php

namespace Drupal\geocoder\Plugin\Geocoder\Formatter;

use Geocoder\Model\Address;

/**
 * Provides a Geocoder Default Formatter plugin.
 *
 * @GeocoderFormatter(
 *   id = "default_geocoder_address_formatter",
 *   name = "Default Geocoder Address Formatter"
 * )
 */
class GeocoderFormattedAddress extends GeocoderFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function format(Address $address) {
    $formatted_address = $this->formatter->format($address, '%S %n, %z %L %c, %C');
    // Clean the address, from double whitespaces, ending/starting commas, etc.
    $this->cleanFormattedAddress($formatted_address);
    return $formatted_address;
  }

}

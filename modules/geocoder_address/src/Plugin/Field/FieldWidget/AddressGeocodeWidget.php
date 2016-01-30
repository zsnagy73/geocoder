<?php

/**
 * @file
 * Contains \Drupal\geocoder_address\Plugin\Field\FieldWidget\AddressGeocodeWidget.
 */

namespace Drupal\geocoder_address\Plugin\Field\FieldWidget;

use Drupal\geocoder\Geocoder;
use Drupal\geocoder\Plugin\Geocoder\InputFormatInterface;
use Drupal\geocoder_field\Plugin\Field\GeocodeBaseWidget;

/**
 * Geocode widget implementation for the Geocoder Field module.
 *
 * @FieldWidget(
 *   id = "geocoder_address_geocode_widget",
 *   label = @Translation("Geocode from/to an existing field"),
 *   field_types = {
 *     "address"
 *   }
 * )
 */
class AddressGeocodeWidget extends GeocodeBaseWidget {

}

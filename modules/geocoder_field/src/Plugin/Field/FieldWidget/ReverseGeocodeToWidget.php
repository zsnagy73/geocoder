<?php

/**
 * @file
 * Contains \Drupal\geocoder_field\Plugin\Field\FieldWidget\ReverseGeocodeToWidget.
 */

namespace Drupal\geocoder_field\Plugin\Field\FieldWidget;

use Drupal\geocoder\Geocoder;
use Drupal\geocoder\Plugin\Geocoder\InputFormatInterface;
use Drupal\geocoder_field\Plugin\Field\GeocodeBaseWidget;
use Drupal\geocoder_field\Plugin\Field\ReverseGeocodeToBaseWidget;

/**
 * Reverse geocode widget implementation for the Geocoder Field module.
 *
 * @FieldWidget(
 *   id = "geocoder_reverse_geocode_to_widget",
 *   label = @Translation("Reverse geocode to an existing field"),
 *   field_types = {
 *     "string",
 *     "file",
 *     "image"
 *   },
 * )
 */
class ReverseGeocodeToWidget extends ReverseGeocodeToBaseWidget {

}

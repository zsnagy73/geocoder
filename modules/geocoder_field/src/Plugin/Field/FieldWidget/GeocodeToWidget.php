<?php

/**
 * @file
 * Contains \Drupal\geocoder_field\Plugin\Field\FieldWidget\GeocodeToWidget.
 */

namespace Drupal\geocoder_field\Plugin\Field\FieldWidget;

use Drupal\geocoder\Geocoder;
use Drupal\geocoder_field\Plugin\Field\GeocodeToBaseWidget;

/**
 * Geocode widget implementation for the Geocoder Field module.
 *
 * @FieldWidget(
 *   id = "geocoder_geocode_to_widget",
 *   label = @Translation("Geocode to an existing field"),
 *   field_types = {
 *     "string",
 *     "file",
 *     "image"
 *   }
 * )
 */
class GeocodeToWidget extends GeocodeToBaseWidget {

}

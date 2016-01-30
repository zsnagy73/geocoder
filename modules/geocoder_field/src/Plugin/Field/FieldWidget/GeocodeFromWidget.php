<?php

/**
 * @file
 * Contains \Drupal\geocoder_field\Plugin\Field\FieldWidget\GeocodeWidget.
 */

namespace Drupal\geocoder_field\Plugin\Field\FieldWidget;

use Drupal\geocoder\Geocoder;
use Drupal\geocoder\Plugin\GeocoderPluginInterface;
use Drupal\geocoder_field\Plugin\Field\GeocodeFromBaseWidget;

/**
 * Geocode widget implementation for the Geocoder Field module.
 *
 * @FieldWidget(
 *   id = "geocoder_geocode_from_widget",
 *   label = @Translation("Geocode from an existing field"),
 *   field_types = {
 *     "string",
 *     "file",
 *     "image"
 *   }
 * )
 */
class GeocodeFromWidget extends GeocodeFromBaseWidget {

}

<?php

/**
 * @file
 * Contains \Drupal\geocoder_field\Plugin\Field\FieldWidget\ReverseGeocodeToBaseWidget.
 */

namespace Drupal\geocoder_field\Plugin\Field;

use Drupal\geocoder\Geocoder;
use Drupal\geocoder\Plugin\Geocoder\InputFormatInterface;
use Drupal\geocoder_field\Plugin\Field\GeocodeBaseWidget;

/**
 * Base reverse geocode 'to' widget implementation for the Geocoder Field module.
 */
abstract class ReverseGeocodeToBaseWidget extends GeocodeBaseWidget {

}

<?php

namespace Drupal\geocoder_geolocation\Plugin\Geocoder\Preprocessor;

use Drupal\geocoder_field\PreprocessorBase;

/**
 * Provides a geocoder preprocessor plugin for geolocation fields.
 *
 * @GeocoderPreprocessor(
 *   id = "geolocation",
 *   name = "Geolocation",
 *   field_types = {
 *     "geolocation"
 *   }
 * )
 */
class Geolocation extends PreprocessorBase {}

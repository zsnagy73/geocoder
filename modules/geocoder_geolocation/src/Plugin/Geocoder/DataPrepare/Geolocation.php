<?php
/**
 * @file
 * The Geolocation Data Prepare plugin.
 */

namespace Drupal\geocoder_geolocation\Plugin\Geocoder\DataPrepare;

use Drupal\geocoder\Plugin\Geocoder\DataPrepareBase;
use Drupal\geocoder\Plugin\GeocoderPluginInterface;

/**
 * Class Geolocation.
 *
 * @GeocoderPlugin(
 *  id = "data_prepare_geolocation",
 *  name = "Geolocation",
 *  field_types = {
 *     "geolocation"
 *   }
 * )
 */
class Geolocation extends DataPrepareBase implements GeocoderPluginInterface {

}

<?php
/**
 * @file
 * The Text Data Prepare plugin.
 */

namespace Drupal\geocoder_field\Plugin\Geocoder\DataPrepare;

use Drupal\geocoder\Plugin\Geocoder\DataPrepare;
use Drupal\geocoder\Plugin\Geocoder\InputFormat;
use Drupal\geocoder\Plugin\Geocoder\InputFormatInterface;
use Drupal\geocoder\Plugin\GeocoderPluginInterface;

/**
 * Class Text.
 *
 * @GeocoderPlugin(
 *  id = "data_prepare_text",
 *  name = "Text",
 *  field_types = {
 *     "string"
 *   }
 * )
 */
class Text extends DataPrepare implements GeocoderPluginInterface {

}

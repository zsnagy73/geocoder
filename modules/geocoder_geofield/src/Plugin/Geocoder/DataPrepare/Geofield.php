<?php
/**
 * @file
 * The Text Data Prepare plugin.
 */

namespace Drupal\geocoder_geofield\Plugin\Geocoder\DataPrepare;

use Drupal\geocoder\Plugin\Geocoder\DataPrepare;
use Drupal\geocoder\Plugin\Geocoder\InputFormat;
use Drupal\geocoder\Plugin\Geocoder\InputFormatInterface;
use Drupal\geocoder\Plugin\GeocoderPluginInterface;

/**
 * Class Geofield.
 *
 * @GeocoderPlugin(
 *  id = "data_prepare_geofield",
 *  name = "Geofield",
 *  field_types = {
 *     "geofield"
 *   }
 * )
 */
class Geofield extends DataPrepare implements GeocoderPluginInterface {
  /**
   * @inheritDoc
   */
  public function getPreparedGeocodeValues(array $values = array()) {
    return parent::getPreparedGeocodeValues($values);
  }

  /**
   * @inheritDoc
   */
  public function getPreparedReverseGeocodeValues(array $values = array()) {
    return parent::getPreparedReverseGeocodeValues($values);
  }


}

<?php
/**
 * @file
 * The File Data Prepare plugin.
 */

namespace Drupal\geocoder_field\Plugin\Geocoder\DataPrepare;

use Drupal\geocoder\Plugin\Geocoder\DataPrepare;
use Drupal\geocoder\Plugin\Geocoder\InputFormat;
use Drupal\geocoder\Plugin\Geocoder\InputFormatInterface;
use Drupal\geocoder\Plugin\GeocoderPluginInterface;

/**
 * Class File.
 *
 * @GeocoderPlugin(
 *  id = "data_prepare_file",
 *  name = "File",
 *  field_types = {
 *     "file",
 *     "image"
 *   }
 * )
 */
class File extends DataPrepare implements GeocoderPluginInterface {
  /**
   * @inheritDoc
   */
  public function getPreparedGeocodeValues(array $values = array()) {
    foreach($values as $index => $value) {
      if ($value['target_id']) {
        $values[$index]['value'] = \Drupal::service('file_system')->realpath(\Drupal\file\Entity\File::load($value['target_id'])->getFileUri());
      }
    }

    return $values;
  }

}

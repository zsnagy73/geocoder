<?php
/**
 * @file
 * The Geohash plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\InputFormat;

use Drupal\Core\Form\FormStateInterface;
use Drupal\geocoder\Plugin\Geocoder\InputFormat;
use Drupal\geocoder\Plugin\Geocoder\InputFormatInterface;

/**
 * Class Geohash.
 *
 * @GeocoderPlugin(
 *  id = "geohash",
 *  name = "Geohash"
 * )
 */
class Geohash extends InputFormat implements InputFormatInterface {
  /**
   * @inheritdoc
   */
  public function massageFormValues(array $values = array(), array $form, FormStateInterface $form_state) {
    foreach ($values as $index => $value) {
      $geometry = \geoPHP::load($value['value'], 'geohash');
      $values[$index] += array(
        'lat' => $geometry->y(),
        'lon' => $geometry->x(),
      );
    }

    return $values;
  }
}

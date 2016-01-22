<?php
/**
 * @file
 * The Wkt plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\InputFormat;

use Drupal\Core\Form\FormStateInterface;
use Drupal\geocoder\Plugin\Geocoder\InputFormat;
use Drupal\geocoder\Plugin\Geocoder\InputFormatInterface;

/**
 * Class Wkt.
 *
 * @GeocoderPlugin(
 *  id = "wkt",
 *  name = "WKT"
 * )
 */
class Wkt extends InputFormat implements InputFormatInterface {
  /**
   * @inheritdoc
   */
  public function massageFormValues(array $values = array(), array $form, FormStateInterface $form_state) {
    foreach ($values as $index => $value) {
      if ($geometry = \geoPHP::load($value['value'], 'wkt')) {
        $values[$index] += array(
          'lat' => $geometry->getCentroid()->y(),
          'lon' => $geometry->getCentroid()->x(),
        );
      }
    }

    return $values;
  }
}

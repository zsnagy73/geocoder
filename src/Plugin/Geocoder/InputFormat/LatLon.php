<?php
/**
 * @file
 * The LatLon plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\InputFormat;
use Drupal\Core\Form\FormStateInterface;
use Drupal\geocoder\Plugin\Geocoder\InputFormat;
use Drupal\geocoder\Plugin\Geocoder\InputFormatInterface;
use Drupal\geocoder\Plugin\GeocoderPluginInterface;

/**
 * Class LatLon.
 *
 * @GeocoderPlugin(
 *  id = "latlon",
 *  name = "Latitude,Longitude"
 * )
 */
class LatLon extends InputFormat implements InputFormatInterface {
  /**
   * @inheritdoc
   */
  public function massageFormValues(array $values = array(), array $form, FormStateInterface $form_state) {
    foreach ($values as $index => $value) {
      list($lat, $lon) = explode(',', $value['value'], 2);
      $values[$index] += array(
        'lat' => trim($lat),
        'lon' => trim($lon),
      );
    }

    return $values;
  }
}

<?php

namespace Drupal\geocoder_geolocation\Plugin\Geocoder\Field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\field\FieldConfigInterface;
use Drupal\geocoder_field\Plugin\Geocoder\Field\DefaultField;

/**
 * Provides a geolocation geocoder field plugin.
 *
 * @GeocoderField(
 *   id = "geolocation",
 *   label = @Translation("Geolocation field plugin"),
 *   field_types = {
 *     "geolocation"
 *   }
 * )
 */
class GeolocationField extends DefaultField {

  /**
   * {@inheritdoc}
   */
  public function getSettingsForm(FieldConfigInterface $field, array $form, FormStateInterface &$form_state) {
    $element = parent::getSettingsForm($field, $form, $form_state);
    // On geolocation the dumper is always 'wkt'.
    $element['dumper'] = [
      '#type' => 'value',
      '#value' => 'wkt',
    ];
    return $element;
  }

}

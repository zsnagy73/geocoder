<?php

namespace Drupal\geocoder_address\Plugin\Geocoder\Field;

use Drupal\Core\Field\FieldConfigInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\geocoder_field\Plugin\Geocoder\Field\DefaultField;

/**
 * Provides a Geocoder Address field plugin.
 *
 * @GeocoderField(
 *   id = "address_field",
 *   label = @Translation("Address field plugin"),
 *   field_types = {
 *     "address"
 *   }
 * )
 */
class AddressField extends DefaultField {

  /**
   * {@inheritdoc}
   */
  public function getSettingsForm(FieldConfigInterface $field, array $form, FormStateInterface &$form_state) {
    $element = parent::getSettingsForm($field, $form, $form_state);

    // The Address Field can just be object of Reverse Geocoding.
    $element['method']['#options'] = [
      'none' => $this->t('No geocoding'),
    ];

    $reverse_geocode_source_fields_options = $this->fieldPluginManager->getReverseGeocodeSourceFields($field->getTargetEntityTypeId(), $field->getTargetBundle(), $field->getName());

    // If the Geocoder Geofield Module exists and there is at least one
    // geofield defined from the entity, extend the Form with Reverse Geocode
    // (from Geofield) capabilities.
    if (!empty($reverse_geocode_source_fields_options) && $this->moduleHandler->moduleExists('geocoder_geofield')) {

      // Add the Option to Reverse Geocode.
      $element['method']['#options']['destination'] = $this->t('<b>Reverse Geocode</b> from a Geofield type existing field');

      // On Address Field the dumper should always be 'geometry'.
      $element['dumper'] = [
        '#type' => 'value',
        '#value' => 'geojson',
      ];

    }

    return $element;
  }

}

<?php

/**
 * @file
 * Contains \Drupal\geocoder_field\Plugin\Field\FieldWidget\ReverseGeocodeWidget.
 */

namespace Drupal\geocoder_field\Plugin\Field\FieldWidget;

use Drupal\Core\Form\FormStateInterface;
use Drupal\geocoder\Geocoder;

/**
 * Reverse geocode widget implementation for the Geocoder Field module.
 *
 * @FieldWidget(
 *   id = "geocoder_reverse_geocode_widget",
 *   label = @Translation("Reverse geocode from/to an existing field"),
 *   field_types = {
 *     "string",
 *     "file",
 *     "geofield"
 *   },
 * )
 */
class ReverseGeocodeWidget extends GeocodeWidget {
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return parent::defaultSettings();
  }

  /**
   * Get a list of input format, specific to this widget.
   *
   * @return array
   */
  public function getInputFormat() {
    return array(
      'latlon' => $this->t('Latitude,longitude'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['input_format'] = array(
      '#type' => 'select',
      '#weight' => 7,
      '#title' => $this->t('Input format'),
      '#description' => $this->t('Select the input format.'),
      '#default_value' => $this->getSetting('input_format'),
      '#required' => TRUE,
      // These options could be extended.
      '#options' => $this->getInputFormat(),
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();
    $available_fields = $this->getAvailableFields();
    $provider_plugin_ids = $this->getEnabledProviderPlugins();
    $delta_handling_options = $this->getDeltaHandling();
    $dumper_plugins = Geocoder::getPlugins('Dumper');
    $input_formats = $this->getInputFormat();
    $dumper_plugin = $this->getSetting('dumper_plugin');
    $input_format = $this->getSetting('input_format');
    $field = $this->getSetting('field');
    $delta_handling = $this->getSetting('delta_handling');

    $summary[] = $this->t('Operating mode: !mode', array('!mode' => $this->getSetting('mode')));

    if (!empty($input_format)) {
      $summary[] = t('Input format: @format', array('@format' => $input_formats[$input_format]));
    }
    if (!empty($field)) {
      $summary[] = $this->t('Field: !field', array('!field' => $available_fields[$field]));
    }
    if (!empty($provider_plugin_ids)) {
      $summary[] = t('Geocoder plugin(s): @plugin_ids', array('@plugin_ids' => implode(', ', $provider_plugin_ids)));
    }
    if (!empty($dumper_plugin)) {
      $summary[] = t('Output format plugin: @format', array('@format' => $dumper_plugins[$dumper_plugin]));
    }
    if (!empty($delta_handling)) {
      $summary[] = t('Delta handling: @delta', array('@delta' => $delta_handling_options[$delta_handling]));
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   *
   * This method is only useful if you use the mode 'To' because we need to
   * rewrite the values of the source field and transform them in
   * latitude longitude.
   * This method is useless when using the mode 'From' because we cannot
   * access to the values of the source (the from) field.
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    $values = parent::massageFormValues($values, $form, $form_state);

    foreach ($values as $delta => $value) {
      switch($this->getSetting('input_format')) {
        case 'latlon':
          list($lat, $lon) = explode(',', $value['value']);
          $values[$delta] += array(
            'lat' => $lat,
            'lon' => $lon,
          );
      }
    }

    return $values;
  }

}

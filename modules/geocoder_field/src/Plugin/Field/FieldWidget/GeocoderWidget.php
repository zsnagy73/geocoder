<?php

/**
 * @file
 * Contains \Drupal\geocoder_field\Plugin\Field\FieldWidget\GeocoderWidget.
 */

namespace Drupal\geocoder_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\geocoder\Geocoder;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Plugin implementation of the 'geocoder_default' widget.
 *
 * @FieldWidget(
 *   id = "geocoder_widget",
 *   label = @Translation("Geocoder"),
 *   field_types = {
 *     "string"
 *   },
 * )
 */
class GeocoderWidget extends WidgetBase {
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'destination_field' => '',
      'placeholder' => '',
      'geocoder_engine' => array('googlemaps'),
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $entityFieldDefinitions = \Drupal::entityManager()->getFieldDefinitions($this->fieldDefinition->getTargetEntityTypeId(), $this->fieldDefinition->getTargetBundle());

    $options = array();
    foreach ($entityFieldDefinitions as $id => $definition) {
      if ($definition->getType() == 'geofield') {
        $options[$id] = $definition->getLabel();
      }
    }

    $elements['destination_field'] = array(
      '#type' => 'select',
      '#title' => $this->t('Destination Geo Field'),
      '#default_value' => $this->getSetting('destination_field'),
      '#required' => TRUE,
      '#options' => $options,
    );

    $elements['placeholder'] = array(
      '#type' => 'textfield',
      '#title' => t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    );

    $enabled_plugins = array();
    $i = 0;
    foreach($this->getSetting('geocoder_engine') as $plugin_id => $plugin) {
      if ($plugin['checked']) {
        $plugin['weight'] = intval($i++);
        $enabled_plugins[$plugin_id] = $plugin;
      }
    }

    $elements['geocoder_engine'] = array(
      '#title' => t('Geocoder engine'),
      '#type' => 'table',
      '#header' => array(
        array('data' => $this->t('Enabled')),
        array('data' => $this->t('Weight')),
        array('data' => $this->t('Name')),
      ),
      '#tabledrag' => array(
        array(
          'action' => 'order',
          'relationship' => 'sibling',
          'group' => 'engine-order-weight',
        ),
      ),
    );

    $rows = array();
    $count = count($enabled_plugins);
    foreach (Geocoder::getPlugins('Provider') as $plugin_id => $plugin_name) {
      if (isset($enabled_plugins[$plugin_id])) {
        $weight = $enabled_plugins[$plugin_id]['weight'];
      } else {
        $weight = $count++;
      }

      $rows[$plugin_id] = array(
        '#attributes' => array(
          'class' => array('draggable'),
        ),
        '#weight' => $weight,
        '#enabled' => isset($enabled_plugins[$plugin_id]) ? 1 : 0,
        //'#name' => $plugin_id,
        'checked' => array(
          '#type' => 'checkbox',
          '#default_value' => isset($enabled_plugins[$plugin_id]) ? 1 : 0,
        ),
        'weight' => array(
          '#type' => 'weight',
          '#title' => t('Weight for @title', array('@title' => $plugin_id)),
          '#title_display' => 'invisible',
          '#default_value' => $weight,
          '#attributes' => array('class' => array('engine-order-weight')),
        ),
        'name' => array(
          '#plain_text' => $plugin_name,
        ),
      );
    }

    uasort($rows, function($a, $b) {
      return strcmp($a['#weight'], $b['#weight']);
    });

    foreach($rows as $plugin_id => $row) {
      $elements['geocoder_engine'][$plugin_id] = $row;
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();
    $summary[] = $this->t('Destination Geofield: !destination', array('!destination' => $this->getSetting('destination_field')));

    $geocoder_engines = Geocoder::getPlugins('Provider');
    $geocoder_engine_value = array_combine($this->getSetting('geocoder_engine'), $this->getSetting('geocoder_engine'));

    $enabled_plugins = array();
    foreach($this->getSetting('geocoder_engine') as $plugin_id => $plugin) {
      if ($plugin['checked']) {
        $enabled_plugins[] = $geocoder_engines[$plugin_id];
      }
    }

    $placeholder = $this->getSetting('placeholder');
    if (!empty($placeholder)) {
      $summary[] = t('Placeholder: @placeholder', array('@placeholder' => $placeholder));
    }
    if (!empty($enabled_plugins)) {
      $summary[] = t('Geocoder engine(s): @placeholder', array('@placeholder' => implode(',', $enabled_plugins)));
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $main_widget = $element + array(
        '#type' => 'textfield',
        '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
        '#placeholder' => $this->getSetting('placeholder'),
        '#attributes' => array('class' => array('geocoder-source')),
      );

    $element['value'] = $main_widget;

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function errorElement(array $element, ConstraintViolationInterface $violation, array $form, FormStateInterface $form_state) {
    if ($violation->arrayPropertyPath == array('format') && isset($element['format']['#access']) && !$element['format']['#access']) {
      // Ignore validation errors for formats if formats may not be changed,
      // i.e. when existing formats become invalid. See filter_process_format().
      return FALSE;
    }
    return $element;
  }
}

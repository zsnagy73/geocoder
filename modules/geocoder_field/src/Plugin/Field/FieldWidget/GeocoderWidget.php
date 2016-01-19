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
      'geocoder_plugins' => array(),
      'dumper_plugin' => 'wkt',
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
      if (in_array($definition->getType(), array('string', 'geofield')) && ($definition->getName() != $this->fieldDefinition->getName())) {
        $options[$id] = sprintf('%s (%s)', $definition->getLabel(), $definition->getType());
      }
    }

    $elements['destination_field'] = array(
      '#type' => 'select',
      '#title' => $this->t('Destination field'),
      '#default_value' => $this->getSetting('destination_field'),
      '#required' => TRUE,
      '#options' => $options,
    );

    $enabled_plugins = array();
    $i = 0;
    foreach($this->getSetting('geocoder_plugins') as $plugin_id => $plugin) {
      if ($plugin['checked']) {
        $plugin['weight'] = intval($i++);
        $enabled_plugins[$plugin_id] = $plugin;
      }
    }

    $elements['geocoder_plugins_title'] = array(
      '#type' => 'item',
      '#title' => t('Geocoder plugin(s)'),
      '#description' => t('Select the Geocoder plugins to use, you can reorder them. The first one to return a valid value will be used.'),
    );

    $elements['geocoder_plugins'] = array(
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
          'group' => 'geocoder_plugins-order-weight',
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
        'checked' => array(
          '#type' => 'checkbox',
          '#default_value' => isset($enabled_plugins[$plugin_id]) ? 1 : 0,
        ),
        'weight' => array(
          '#type' => 'weight',
          '#title' => t('Weight for @title', array('@title' => $plugin_id)),
          '#title_display' => 'invisible',
          '#default_value' => $weight,
          '#attributes' => array('class' => array('geocoder_plugins-order-weight')),
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
      $elements['geocoder_plugins'][$plugin_id] = $row;
    }

    $elements['dumper_plugin'] = array(
      '#type' => 'select',
      '#title' => 'Output format',
      '#default_value' => $this->getSetting('dumper_plugin'),
      '#options' => Geocoder::getPlugins('dumper'),
      '#description' => t('Set the output format of the value. Ex, for a geofield, the format must be set to WKT.')
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();
    $dumper_plugin = $this->getSetting('dumper_plugin');

    $summary[] = $this->t('Destination Geofield: !destination', array('!destination' => $this->getSetting('destination_field')));

    $geocoder_plugins = Geocoder::getPlugins('Provider');
    $dumper_plugins = Geocoder::getPlugins('Dumper');

    // Find the enabled geocoder plugins.
    $geocoder_plugin_ids = array();
    foreach($this->getSetting('geocoder_plugins') as $plugin_id => $plugin) {
      if ($plugin['checked']) {
        $geocoder_plugin_ids[] = $geocoder_plugins[$plugin_id];
      }
    }

    if (!empty($geocoder_plugin_ids)) {
      $summary[] = t('Geocoder plugin(s): @plugin_ids', array('@plugin_ids' => implode(', ', $geocoder_plugin_ids)));
    }
    if (!empty($dumper_plugin)) {
      $summary[] = t('Output format plugin: @format', array('@format' => $dumper_plugins[$dumper_plugin]));
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

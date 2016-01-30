<?php

/**
 * @file
 * Contains \Drupal\geocoder_field\Plugin\Field\FieldWidget\GeocodeFromBaseWidget.
 */

namespace Drupal\geocoder_field\Plugin\Field;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\geocoder\Geocoder;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Base geocode 'from' widget implementation for the Geocoder Field module.
 */
abstract class GeocodeFromBaseWidget extends GeocodeBaseWidget {
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'geocoder_type' => 'from',
    ) + parent::defaultSettings();
  }
}

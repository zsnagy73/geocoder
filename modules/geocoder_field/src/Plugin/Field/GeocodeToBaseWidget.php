<?php

/**
 * @file
 * Contains \Drupal\geocoder_field\Plugin\Field\FieldWidget\GeocodeToBaseWidget.
 */

namespace Drupal\geocoder_field\Plugin\Field;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\geocoder\Geocoder;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Base geocode 'to' widget implementation for the Geocoder Field module.
 */
abstract class GeocodeToBaseWidget extends GeocodeBaseWidget {
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'geocoder_type' => 'to',
    ) + parent::defaultSettings();
  }
}

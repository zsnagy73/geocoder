<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\Geocoder\InputFormat.
 */

namespace Drupal\geocoder\Plugin\Geocoder;

use Drupal\Core\Form\FormStateInterface;
use Drupal\geocoder\Plugin\GeocoderPlugin;
use Drupal\geocoder\Plugin\GeocoderPluginInterface;

abstract class InputFormat extends GeocoderPlugin implements GeocoderPluginInterface {
  /**
   * @inheritdoc
   */
  public function massageFormValues(array $values = array(), array $form, FormStateInterface $form_state) {
    return $values;
  }

}

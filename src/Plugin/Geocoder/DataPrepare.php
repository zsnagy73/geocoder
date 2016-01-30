<?php
/**
 * @file
 * The Data Prepare plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder;

use Drupal\Core\Entity\EntityInterface;
use Drupal\geocoder\Plugin\Geocoder\DataPrepareInterface;
use Drupal\geocoder\Plugin\GeocoderPlugin;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DataPrepare.
 */
abstract class DataPrepare extends GeocoderPlugin implements DataPrepareInterface {
  /**
   * @var EntityInterface
   */
  private $entity;

  /**
   * @var string
   */
  private $field_id;

  /**
   * @var array
   */
  private $values;

  /**
   * @var string[]
   */
  private $widget_ids;

  /**
   * @var array
   */
  private $widget_configuration;

  /**
   * @inheritDoc
   */
  public function setEntity(EntityInterface $entity) {
    $this->entity = $entity;

    return $this;
  }

  /**
   * @inheritDoc
   */
  public function getEntity() {
    return $this->entity;
  }

  /**
   * @param array $widgets
   *
   * @return $this
   */
  public function setWidgetIds(array $widgets = array()) {
    $this->widget_ids = $widgets;

    return $this;
  }

  public function getWidgetIds() {
    return $this->widget_ids;
  }

  /**
   * @param array $widgets
   *
   * @return $this
   */
  public function setValues(array $values = array()) {
    $this->values = $values;

    return $this;
  }

  public function getValues() {
    return $this->values;
  }

  /**
   * @param array $settings
   *
   * @return $this
   */
  public function setWidgetConfiguration(array $settings = array()) {
    $this->widget_configuration = $settings;

    return $this;
  }

  /**
   * @return mixed
   */
  public function getWidgetConfiguration() {
    return $this->widget_configuration;
  }

  /**
   * @param $field_id
   *
   * @return $this
   */
  public function setCurrentField($field_id) {
    $this->field_id = $field_id;

    return $this;
  }

  /**
   * @return string
   */
  public function getCurrentField() {
    return $this->field_id;
  }

  /**
   * @param array $values
   *
   * @return array
   */
  public function getPreparedGeocodeValues(array $values = array()) {
    return $this->setValues($values)->getValues();
  }

  /**
   * @param array $values
   *
   * @return array
   */
  public function getPreparedReverseGeocodeValues(array $values = array()) {
    foreach($values as $index => $value) {
      list($lat, $lon) = explode(',', trim($value['value']));
      $values[$index] += array(
        'lat' => trim($lat),
        'lon' => trim($lon)
      );
    }

    return $values;
  }

  /**
   * @inheritdoc
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
  }

}

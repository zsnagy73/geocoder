<?php
/**
 * @file
 * The Data Prepare plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\geocoder\Plugin\GeocoderPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DataPrepare.
 */
abstract class DataPrepareBase extends GeocoderPluginBase implements DataPrepareInterface {
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
   * The geocoder settings.
   *
   * @var array
   */
  private $geocoderSettings;

  /**
   * {@inheritdoc}
   */
  public function setEntity(ContentEntityInterface $entity) {
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

  /**
   *
   */
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

  /**
   *
   */
  public function getValues() {
    return $this->values;
  }

  /**
   * {@inheritdoc}
   */
  public function setGeocoderSettings(array $settings) {
    $this->geocoderSettings = $settings;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getGeocoderSettings() {
    return $this->geocoderSettings;
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
   * {@inheritdoc}
   */
  public function prepareValues(array &$values) {
    $values = $this->setValues($values)->getValues();
    return $this;
  }

  /**
   * @param array $values
   *
   * @return array
   */
  public function getPreparedReverseGeocodeValues(array $values = array()) {
    foreach ($values as $index => $value) {
      list($lat, $lon) = explode(',', trim($value['value']));
      $values[$index] += array(
        'lat' => trim($lat),
        'lon' => trim($lon),
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

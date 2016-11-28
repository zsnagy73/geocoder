<?php

namespace Drupal\geocoder\Plugin\Geocoder;

use Drupal\Core\Entity\EntityInterface;
use Drupal\geocoder\Plugin\GeocoderPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DataPrepare.
 */
abstract class DataPrepareBase extends GeocoderPluginBase implements DataPrepareInterface {
  /**
   * Entity.
   *
   * @var EntityInterface
   */
  private $entity;

  /**
   * Field Id.
   *
   * @var string
   */
  private $field_id;

  /**
   * Array of Values.
   *
   * @var array
   */
  private $values;

  /**
   * Widget Id.
   *
   * @var string[]
   */
  private $widget_ids;

  /**
   * Widget Configuration.
   *
   * @var array
   */
  private $widget_configuration;

  /**
   * Set Entity.
   *
   * @inheritDoc
   */
  public function setEntity(EntityInterface $entity) {
    $this->entity = $entity;

    return $this;
  }

  /**
   * Get Entity.
   *
   * @inheritDoc
   */
  public function getEntity() {
    return $this->entity;
  }

  /**
   * Set Wiget ID.
   *
   * @inheritDoc
   */
  public function setWidgetIds(array $widgets = array()) {
    $this->widget_ids = $widgets;

    return $this;
  }

  /**
   * Get widget ID.
   *
   * @inheritDoc
   */
  public function getWidgetIds() {
    return $this->widget_ids;
  }

  /**
   * Set Values.
   *
   * @inheritDoc
   */
  public function setValues(array $values = array()) {
    $this->values = $values;

    return $this;
  }

  /**
   * Get Values.
   *
   * @inheritDoc
   */
  public function getValues() {
    return $this->values;
  }

  /**
   * Set the Widget Configuration.
   *
   * @inheritDoc
   */
  public function setWidgetConfiguration(array $settings = array()) {
    $this->widget_configuration = $settings;

    return $this;
  }

  /**
   * Get the widget configuration.
   *
   * @inheritDoc
   */
  public function getWidgetConfiguration() {
    return $this->widget_configuration;
  }

  /**
   * Set the Current Field.
   *
   * @inheritDoc
   */
  public function setCurrentField($field_id) {
    $this->field_id = $field_id;

    return $this;
  }

  /**
   * Get the current field.
   *
   * @inheritDoc
   */
  public function getCurrentField() {
    return $this->field_id;
  }

  /**
   * Get prepared Geocode Values.
   *
   * @inheritDoc
   */
  public function getPreparedGeocodeValues(array $values = array()) {
    return $this->setValues($values)->getValues();
  }

  /**
   * Get reverse geocode values.
   *
   * @inheritDoc
   */
  public function getPreparedReverseGeocodeValues(array $values = array()) {
    return $this->setValues($values)->getValues();
  }

  /**
   * Create function.
   *
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

<?php
/**
 * @file
 * The Data Prepare Interface.
 */

namespace Drupal\geocoder\Plugin\Geocoder;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Interface DataPrepareInterface.
 */
interface DataPrepareInterface extends PluginInspectionInterface, ContainerFactoryPluginInterface {
  /**
   * Set the input values.
   *
   * @param array $values
   *
   * @return $this
   */
  public function setValues(array $values = array());

  /**
   * Get the input values.
   *
   * @return array
   */
  public function getValues();

  /**
   * Set the entity to work on.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The content entity.
   *
   * @return $this
   */
  public function setEntity(ContentEntityInterface $entity);

  /**
   * Get the entity.
   *
   * @return EntityInterface
   */
  public function getEntity();

  /**
   * Sets the geofield field settings.
   *
   * @param array $settings
   *   The geofield field settings stored as third party settings in geofield
   *   field settings.
   *
   * @return $this
   */
  public function setGeocoderSettings(array $settings);

  /**
   * @return mixed
   */
  public function getGeocoderSettings();

  /**
   * @param $field_id
   *
   * @return $this
   */
  public function setCurrentField($field_id);

  /**
   * @return string
   */
  public function getCurrentField();

  /**
   * Prepare values before geocoding.
   *
   * @param array $values
   *   The field values passed as reference to be prepared.
   *
   * @return $this
   */
  public function prepareGeocodeValues(array &$values = array());

  /**
   * Prepare values before reverse geocoding.
   *
   * @param array $values
   *   The field values passed as reference to be prepared.
   *
   * @return $this
   */
  public function prepareReverseGeocodeValues(array &$values = array());

}

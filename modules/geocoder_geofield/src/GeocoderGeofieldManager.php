<?php

/**
 * @file
 * Contains \Drupal\geocoder_geofield\GeocoderGeofieldManager.
 */

namespace Drupal\geocoder_geofield;

use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\geocoder\Plugin\GeocoderPluginManager;

/**
 * Provides utility methods for Geofield Geocode module.
 */
class GeocoderGeofieldManager {

  /**
   * The geocoder plugin manager service.
   *
   * @var \Drupal\geocoder\Plugin\GeocoderPluginManager
   */
  protected $geocoderPluginManager;

  /**
   * The entity field manager service.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * Constructs a GeocoderGeofieldUtility service class.
   *
   * @param \Drupal\geocoder\Plugin\GeocoderPluginManager $geocoder_plugin_manager
   *   The geocoder plugin manager service.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The entity field manager service.
   */
  public function __construct(GeocoderPluginManager $geocoder_plugin_manager, EntityFieldManagerInterface $entity_field_manager) {
    $this->geocoderPluginManager = $geocoder_plugin_manager;
    $this->entityFieldManager = $entity_field_manager;
  }

  /**
   * Gets a list of available fields to be used as source for geofield field.
   *
   * @param string $entity_type_id
   *   The entity type id.
   * @param string $bundle
   *   The bundle.
   * @param string $field_name
   *   The filed name.
   *
   * @return array
   */
  public function getFields($entity_type_id, $bundle, $field_name) {
    $options = array();

    $types = [];
    foreach ($this->geocoderPluginManager->getDefinitions() as $definition) {
      foreach ($definition['field_types'] as $field_type) {
        $types[] = $field_type;
      }
    }

    foreach ($this->entityFieldManager->getFieldDefinitions($entity_type_id, $bundle) as $id => $definition) {
      if (in_array($definition->getType(), $types) && ($definition->getName()) !== $field_name) {
        $options[$id] = new TranslatableMarkup('@label (@name) [@type]', ['@label' => $definition->getLabel(), '@name' => $definition->getName(), '@type' => $definition->getType()]);
      }
    }

    return $options;
  }

}
<?php

/**
 * @file
 * Contains \Drupal\Tests\geocoder_geofield\Kernel\GeocoderGeofieldIntegrationTest.
 */

namespace Drupal\Tests\geocoder_geofield\Kernel;

use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\KernelTests\KernelTestBase;

/**
 * Tests the integration between geocoder with geofield.
 *
 * @group geocoder
 */
class GeocoderGeofieldIntegrationTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['geophp', 'geofield', 'system', 'field', 'geocoder_geofield', 'geocoder', 'entity_test', 'text'];

  /**
   * Tests the
   */
  public function testGeofield() {
    FieldStorageConfig::create([
      'entity_type' => 'entity_test',
      'type' => 'geofield',
      'field_name' => 'foo',
    ])->save();
    $field = FieldConfig::create([
      'entity_type' => 'entity_test',
      'bundle' => 'entity_test',
      'field_name' => 'foo',
    ]);
    $field->save();
    FieldStorageConfig::create([
      'entity_type' => 'entity_test',
      'type' => 'text',
      'field_name' => 'bar',
    ])->save();
    $source_field = FieldConfig::create([
      'entity_type' => 'entity_test',
      'bundle' => 'entity_test',
      'field_name' => 'bar',
    ])->save();
    $this->assertTrue(1);
  }

}

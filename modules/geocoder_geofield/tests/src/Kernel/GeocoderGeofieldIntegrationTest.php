<?php

/**
 * @file
 * Contains \Drupal\Tests\geocoder_geofield\Kernel\GeocoderGeofieldIntegrationTest.
 */

namespace Drupal\Tests\geocoder_geofield\Kernel;

use Drupal\entity_test\Entity\EntityTest;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\geocoder\Plugin\Geocoder\Provider\GoogleMaps;
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
  public static $modules = ['geophp', 'geofield', 'field', 'geocoder_geofield', 'geocoder_geofield_test', 'geocoder', 'entity_test', 'text', 'user', 'filter'];

  /**
   * Tests the
   */
  public function testGeofield() {
    $this->installEntitySchema('entity_test');

    // The remote field.
    FieldStorageConfig::create([
      'entity_type' => 'entity_test',
      'type' => 'text',
      'field_name' => 'foo',
    ])->save();
    $remote_field = FieldConfig::create([
      'entity_type' => 'entity_test',
      'bundle' => 'entity_test',
      'field_name' => 'foo',
    ])->save();
    // The 'geofield' type field.
    FieldStorageConfig::create([
      'entity_type' => 'entity_test',
      'type' => 'geofield',
      'field_name' => 'bar',
    ])->save();
    $field = FieldConfig::create([
      'entity_type' => 'entity_test',
      'bundle' => 'entity_test',
      'field_name' => 'bar',
      'third_party_settings' => [
        'geocoder_geofield' => [
          'method' => 'source',
          'field' => 'foo',
          'plugins' => ['test_provider'],
          'dumper' => 'wkt',
          'delta_handling' => 'default',
        ],
      ],
    ]);
    $field->save();

    /** @var \Drupal\entity_test\Entity\EntityTest $entity */
    $entity = EntityTest::create(['name' => 'Baz', 'bundle' => 'entity_test']);
    $entity->foo->value = 'Gotham City';
    $entity->save();

    $this->assertSame('POINT(40.000000 20.000000)', $entity->bar->value);
  }

}

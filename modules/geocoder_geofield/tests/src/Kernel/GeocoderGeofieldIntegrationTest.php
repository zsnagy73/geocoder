<?php

/**
 * @file
 * Contains \Drupal\Tests\geocoder_geofield\Kernel\GeocoderGeofieldIntegrationTest.
 */

namespace Drupal\Tests\geocoder_geofield\Kernel;

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
  public static $modules = ['geophp', 'geofield', 'system', 'field', 'geocoder_geofield', 'geocoder'];

  /**
   * Tests the...
   */
  public function testGeofield() {
    $this->assertTrue(1);
  }

}

<?php
/**
 * @file
 * Map: Map.
 */

namespace Drupal\geocoder\Plugin\Provider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\GoogleMaps;
use Geocoder\Provider\Provider;

/**
 * Class Google.
 *
 * @GeocoderProviderPlugin(
 *  id = "Google",
 *  arguments = {
 *    "@geocoder.http_adapter"
 *  }
 * )
 */

class Google extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $this->setHandler(new GoogleMaps($this->getAdapter()));

    return parent::init();
  }
}
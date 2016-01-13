<?php
/**
 * @file
 * The GoogleMaps plugin.
 */

namespace Drupal\geocoder\Plugin\GeocoderProvider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class GoogleMaps.
 *
 * @GeocoderProviderPlugin(
 *  id = "GoogleMaps",
 *  arguments = {
 *    "@geocoder.http_adapter"
 *  }
 * )
 */
class GoogleMaps extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $this->setHandler(new \Geocoder\Provider\GoogleMaps($this->getAdapter()));

    return parent::init();
  }

}

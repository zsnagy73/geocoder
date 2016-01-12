<?php
/**
 * @file
 * The Geoip plugin.
 */

namespace Drupal\geocoder\Plugin\Provider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class Geoip.
 *
 * @GeocoderProviderPlugin(
 *  id = "Geoip",
 *  arguments = {
 *    "@geocoder.http_adapter"
 *  }
 * )
 */

class Geoip extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $this->setHandler(new \Geocoder\Provider\Geoip());

    return parent::init();
  }
}
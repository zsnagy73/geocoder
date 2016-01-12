<?php
/**
 * @file
 * The Geonames plugin.
 */

namespace Drupal\geocoder\Plugin\Provider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class Geonames.
 *
 * @GeocoderProviderPlugin(
 *  id = "Geonames",
 *  arguments = {
 *    "@geocoder.http_adapter"
 *  }
 * )
 */

class Geonames extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\Geonames($this->getAdapter(), $configuration['username']));

    return parent::init();
  }
}
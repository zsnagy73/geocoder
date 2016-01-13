<?php
/**
 * @file
 * The OpenStreetMap plugin.
 */

namespace Drupal\geocoder\Plugin\GeocoderProvider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class OpenStreetMap.
 *
 * @GeocoderProviderPlugin(
 *  id = "OpenStreetMap",
 *  arguments = {
 *    "@geocoder.http_adapter"
 *  }
 * )
 */
class OpenStreetMap extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $this->setHandler(new \Geocoder\Provider\OpenStreetMap($this->getAdapter()));

    return parent::init();
  }

}

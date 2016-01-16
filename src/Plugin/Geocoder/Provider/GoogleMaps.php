<?php
/**
 * @file
 * The GoogleMaps plugin.
 */

namespace Drupal\geocoder\Plugin\Provider;

use Drupal\geocoder\GeocoderProvider;

/**
 * Class GoogleMaps.
 *
 * @GeocoderProviderPlugin(
 *  id = "googlemaps",
 *  name = "GoogleMaps",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
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

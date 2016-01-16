<?php
/**
 * @file
 * The OpenStreetMap plugin.
 */

namespace Drupal\geocoder\Plugin\Provider;

use Drupal\geocoder\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class OpenStreetMap.
 *
 * @GeocoderProviderPlugin(
 *  id = "openstreetmap",
 *  name = "OpenStreetMap",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
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

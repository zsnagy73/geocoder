<?php
/**
 * @file
 * The Geonames plugin.
 */

namespace Drupal\geocoder\Plugin\GeocoderProvider;

use Drupal\geocoder\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class Geonames.
 *
 * @GeocoderProviderPlugin(
 *  id = "geonames",
 *  name = "Geonames",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
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

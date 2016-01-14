<?php
/**
 * @file
 * The BingMaps plugin.
 */

namespace Drupal\geocoder\Plugin\GeocoderProvider;

use Drupal\geocoder\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class BingMaps.
 *
 * @GeocoderProviderPlugin(
 *  id = "BingMaps",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class BingMaps extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\BingMaps($this->getAdapter(), $configuration['apiKey']));

    return parent::init();
  }

}

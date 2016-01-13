<?php
/**
 * @file
 * The MaxMind plugin.
 */

namespace Drupal\geocoder\Plugin\GeocoderProvider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class MaxMind.
 *
 * @GeocoderProviderPlugin(
 *  id = "MaxMind",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class MaxMind extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\MaxMind($this->getAdapter(), $configuration['apiKey']));

    return parent::init();
  }

}

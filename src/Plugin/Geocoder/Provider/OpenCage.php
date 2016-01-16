<?php
/**
 * @file
 * The OpenCage plugin.
 */

namespace Drupal\geocoder\Plugin\Provider;

use Drupal\geocoder\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class OpenCage.
 *
 * @GeocoderProviderPlugin(
 *  id = "opencage",
 *  name = "OpenCage",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class OpenCage extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\OpenCage($this->getAdapter(), $configuration['apiKey']));

    return parent::init();
  }

}

<?php
/**
 * @file
 * The OpenCage plugin.
 */

namespace Drupal\geocoder\Plugin\GeocoderProvider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class OpenCage.
 *
 * @GeocoderProviderPlugin(
 *  id = "OpenCage",
 *  arguments = {
 *    "@geocoder.http_adapter"
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

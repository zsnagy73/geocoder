<?php
/**
 * @file
 * The HostIp plugin.
 */

namespace Drupal\geocoder\Plugin\Provider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class HostIp.
 *
 * @GeocoderProviderPlugin(
 *  id = "HostIp",
 *  arguments = {
 *    "@geocoder.http_adapter"
 *  }
 * )
 */
class HostIp extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $this->setHandler(new \Geocoder\Provider\HostIp($this->getAdapter()));

    return parent::init();
  }

}

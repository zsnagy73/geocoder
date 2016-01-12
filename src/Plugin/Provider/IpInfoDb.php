<?php
/**
 * @file
 * The IpInfoDb plugin.
 */

namespace Drupal\geocoder\Plugin\Provider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class IpInfoDb.
 *
 * @GeocoderProviderPlugin(
 *  id = "IpInfoDb",
 *  arguments = {
 *    "@geocoder.http_adapter"
 *  }
 * )
 */
class IpInfoDb extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\IpInfoDb($this->getAdapter(), $configuration['apiKey']));

    return parent::init();
  }

}

<?php
/**
 * @file
 * The GoogleMaps plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Drupal\geocoder\Plugin\Geocoder\Provider;

/**
 * Class GoogleMaps.
 *
 * @GeocoderPlugin(
 *  id = "googlemaps",
 *  name = "GoogleMaps",
 *  type = "Provider",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class GoogleMaps extends Provider implements ProviderInterface {
  /**
   * @inheritdoc
   */
  public function init() {
    $this->setHandler(new \Geocoder\Provider\GoogleMaps($this->getAdapter()));

    return parent::init();
  }

}

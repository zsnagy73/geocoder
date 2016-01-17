<?php
/**
 * @file
 * The FreeGeoIp plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Drupal\geocoder\Plugin\Geocoder\Provider;
use Geocoder\Geocoder;


/**
 * Class FreeGeoIp.
 *
 * @GeocoderPlugin(
 *  id = "freegeoip",
 *  name = "FreeGeoIp",
 *  type = "Provider",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class FreeGeoIp extends Provider implements ProviderInterface {
  /**
   * @inheritdoc
   */
  public function init() {
    $this->setHandler(new \Geocoder\Provider\FreeGeoIp($this->getAdapter()));

    return parent::init();
  }

}

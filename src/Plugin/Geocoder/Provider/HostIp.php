<?php
/**
 * @file
 * The HostIp plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Drupal\geocoder\Plugin\Geocoder\Provider;
use Geocoder\Geocoder;


/**
 * Class HostIp.
 *
 * @GeocoderPlugin(
 *  id = "hostip",
 *  name = "HostIp",
 *  type = "Provider",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class HostIp extends Provider implements ProviderInterface {
  /**
   * @inheritdoc
   */
  public function init() {
    $this->setHandler(new \Geocoder\Provider\HostIp($this->getAdapter()));

    return parent::init();
  }

}

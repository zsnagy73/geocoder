<?php
/**
 * @file
 * The IpInfoDb plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Drupal\geocoder\Plugin\Geocoder\Provider;
use Geocoder\Geocoder;


/**
 * Class IpInfoDb.
 *
 * @GeocoderPlugin(
 *  id = "ipinfodb",
 *  name = "IpInfoDb",
 *  type = "Provider",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class IpInfoDb extends Provider implements ProviderInterface {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\IpInfoDb($this->getAdapter(), $configuration['apiKey']));

    return parent::init();
  }

}

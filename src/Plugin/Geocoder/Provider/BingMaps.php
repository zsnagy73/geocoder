<?php
/**
 * @file
 * The BingMaps plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Drupal\geocoder\Plugin\Geocoder\Provider;
use Geocoder\Geocoder;


/**
 * Class BingMaps.
 *
 * @GeocoderPlugin(
 *  id = "bingmaps",
 *  name = "BingMaps",
 *  type = "Provider",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class BingMaps extends Provider implements ProviderInterface {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\BingMaps($this->getAdapter(), $configuration['apiKey']));

    return parent::init();
  }

}

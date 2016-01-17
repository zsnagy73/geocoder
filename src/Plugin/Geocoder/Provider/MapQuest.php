<?php
/**
 * @file
 * The MapQuest plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Drupal\geocoder\Plugin\Geocoder\Provider;
use Geocoder\Geocoder;


/**
 * Class MapQuest.
 *
 * @GeocoderPlugin(
 *  id = "mapquest",
 *  name = "MapQuest",
 *  type = "Provider",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class MapQuest extends Provider implements ProviderInterface {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\MapQuest($this->getAdapter(), $configuration['apiKey'], $configuration['licensed']));

    return parent::init();
  }

}

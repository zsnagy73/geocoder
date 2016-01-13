<?php
/**
 * @file
 * The MapQuest plugin.
 */

namespace Drupal\geocoder\Plugin\GeocoderProvider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class MapQuest.
 *
 * @GeocoderProviderPlugin(
 *  id = "MapQuest",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class MapQuest extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\MapQuest($this->getAdapter(), $configuration['apiKey'], $configuration['licensed']));

    return parent::init();
  }

}

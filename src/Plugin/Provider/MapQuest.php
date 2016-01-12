<?php
/**
 * @file
 * The MapQuest plugin.
 */

namespace Drupal\geocoder\Plugin\Provider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class MapQuest.
 *
 * @GeocoderProviderPlugin(
 *  id = "MapQuest",
 *  arguments = {
 *    "@geocoder.http_adapter"
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

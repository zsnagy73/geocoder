<?php
/**
 * @file
 * The Yandex plugin.
 */

namespace Drupal\geocoder\Plugin\GeocoderProvider;

use Drupal\geocoder\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class Yandex.
 *
 * @GeocoderProviderPlugin(
 *  id = "yandex",
 *  name = "Yandex",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class Yandex extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $this->setHandler(new \Geocoder\Provider\Yandex($this->getAdapter()));

    return parent::init();
  }

}

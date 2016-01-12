<?php
/**
 * @file
 * The Yandex plugin.
 */

namespace Drupal\geocoder\Plugin\Provider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class Yandex.
 *
 * @GeocoderProviderPlugin(
 *  id = "Yandex",
 *  arguments = {
 *    "@geocoder.http_adapter"
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

<?php
/**
 * @file
 * The GeoPlugin plugin.
 */

namespace Drupal\geocoder\Plugin\Provider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class GeoPlugin.
 *
 * @GeocoderProviderPlugin(
 *  id = "GeoPlugin",
 *  arguments = {
 *    "@geocoder.http_adapter"
 *  }
 * )
 */
class GeoPlugin extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $this->setHandler(new \Geocoder\Provider\GeoPlugin());

    return parent::init();
  }

}

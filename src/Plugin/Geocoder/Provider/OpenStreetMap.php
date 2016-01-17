<?php
/**
 * @file
 * The OpenStreetMap plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Drupal\geocoder\Plugin\Geocoder\Provider;
use Geocoder\Geocoder;


/**
 * Class OpenStreetMap.
 *
 * @GeocoderPlugin(
 *  id = "openstreetmap",
 *  name = "OpenStreetMap",
 *  type = "Provider",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class OpenStreetMap extends Provider implements ProviderInterface {
  /**
   * @inheritdoc
   */
  public function init() {
    $this->setHandler(new \Geocoder\Provider\OpenStreetMap($this->getAdapter()));

    return parent::init();
  }

}

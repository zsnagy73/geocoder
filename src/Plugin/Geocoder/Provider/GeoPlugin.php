<?php
/**
 * @file
 * The GeoPlugin plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Drupal\geocoder\Plugin\Geocoder\Provider;
use Geocoder\Geocoder;


/**
 * Class GeoPlugin.
 *
 * @GeocoderPlugin(
 *  id = "geoplugin",
 *  name = "GeoPlugin",
 *  type = "Provider",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class GeoPlugin extends Provider implements ProviderInterface {
  /**
   * @inheritdoc
   */
  public function init() {
    $this->setHandler(new \Geocoder\Provider\GeoPlugin());

    return parent::init();
  }

}

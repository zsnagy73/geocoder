<?php
/**
 * @file
 * The Geonames plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Drupal\geocoder\Plugin\Geocoder\Provider;
use Geocoder\Geocoder;


/**
 * Class Geonames.
 *
 * @GeocoderPlugin(
 *  id = "geonames",
 *  name = "Geonames",
 *  type = "Provider",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class Geonames extends Provider implements ProviderInterface {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\Geonames($this->getAdapter(), $configuration['username']));

    return parent::init();
  }

}

<?php
/**
 * @file
 * The Nominatim plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Drupal\geocoder\Plugin\Geocoder\Provider;
use Geocoder\Geocoder;


/**
 * Class Nominatim.
 *
 * @GeocoderPlugin(
 *  id = "nominatim",
 *  name = "Nominatim",
 *  type = "Provider",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class Nominatim extends Provider implements ProviderInterface {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\Nominatim($this->getAdapter(), $configuration['rootUrl']));

    return parent::init();
  }

}

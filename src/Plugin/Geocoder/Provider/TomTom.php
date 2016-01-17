<?php
/**
 * @file
 * The TomTom plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Drupal\geocoder\Plugin\Geocoder\Provider;
use Geocoder\Geocoder;


/**
 * Class TomTom.
 *
 * @GeocoderPlugin(
 *  id = "tomtom",
 *  name = "TomTom",
 *  type = "Provider",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class TomTom extends Provider implements ProviderInterface {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\TomTom($this->getAdapter(), $configuration['apiKey']));

    return parent::init();
  }

}

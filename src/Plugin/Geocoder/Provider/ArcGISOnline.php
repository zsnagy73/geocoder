<?php
/**
 * @file
 * The ArcGISOnline plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\Provider;
use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Geocoder\Geocoder;

/**
 * Class ArcGISOnline.
 *
 * @GeocoderPlugin(
 *  id = "arcgisonline",
 *  name = "ArcGISOnline",
 *  type = "Provider",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class ArcGISOnline extends Provider implements ProviderInterface {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\ArcGISOnline($this->getAdapter(), $configuration['sourceCountry']));

    return parent::init();
  }

}

<?php
/**
 * @file
 * The ArcGISOnline plugin.
 */

namespace Drupal\geocoder\Plugin\GeocoderProvider;

use Drupal\geocoder\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Provider\Provider;

/**
 * Class ArcGISOnline.
 *
 * @GeocoderProviderPlugin(
 *  id = "arcgisonline",
 *  name = "ArcGISOnline",
 *  arguments = {
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
 *  }
 * )
 */
class ArcGISOnline extends GeocoderProvider {
  /**
   * @inheritdoc
   */
  public function init() {
    $configuration = $this->getConfiguration();
    $this->setHandler(new \Geocoder\Provider\ArcGISOnline($this->getAdapter(), $configuration['sourceCountry']));

    return parent::init();
  }

}

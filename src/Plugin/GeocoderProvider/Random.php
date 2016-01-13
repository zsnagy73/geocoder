<?php
/**
 * @file
 * The TomTom plugin.
 */

namespace Drupal\geocoder\Plugin\GeocoderProvider;

use Drupal\geocoder\GeocoderProvider\GeocoderProvider;
use Geocoder\Geocoder;
use Geocoder\Model\Address;
use Geocoder\Model\AddressCollection;
use Geocoder\Model\AddressFactory;
use Geocoder\Model\Coordinates;
use Geocoder\Provider\Provider;

/**
 * Class Random.
 *
 * @GeocoderProviderPlugin(
 *  id = "Random",
 *  arguments = {
 *    "@geocoder.http_adapter"
 *  }
 * )
 */
class Random extends GeocoderProvider {
  /**
   * @var AddressFactory
   */
  private $factory;

  public function init() {
    $this->factory = new AddressFactory();
  }

  public function geocode($data) {
    $result = array(
      'latitude' => mt_rand(0, 90),
      'longitude' => mt_rand(-180, 180),
    );

    return $this->factory->createFromArray(array($result));
  }

  public function reverse($latitude, $longitude) {
    // TODO.
  }
}

<?php

/**
 * @file
 * Contains \Drupal\geocoder_geofield_test\Plugin\Geocoder\Provider\TestProvider.
 */

namespace Drupal\geocoder_geofield_test\Plugin\Geocoder\Provider;

use Drupal\geocoder\Plugin\Geocoder\ProviderBase;
use Drupal\geocoder\Plugin\Geocoder\ProviderInterface;
use Geocoder\Model\AddressFactory;

/**
 * Provides a geocoding providers for testing purposes.
 *
 * @GeocoderPlugin(
 *  id = "test_provider",
 *  name = "Test provider"
 * )
 */
class TestProvider extends ProviderBase implements ProviderInterface {

  /**
   * The address factory.
   *
   * @var \Geocoder\Model\AddressFactory
   */
  protected $addressFactory;

  /**
   * {@inheritdoc}
   */
  public function init() {
    $this->addressFactory = new AddressFactory();
  }

  /**
   * {@inheritdoc}
   */
  public function geocode($data) {
    switch ($data) {
      case 'Gotham City':
        return $this->addressFactory->createFromArray([['latitude' => 20, 'longitude' => 40]]);
      default:
        return FALSE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function reverse($latitude, $longitude) {
    return FALSE;
  }

}

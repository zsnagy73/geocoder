<?php

/**
 * @file
 * Contains \Drupal\geocoder\Geocoder\Provider\Random.
 */

namespace Drupal\geocoder\Geocoder\Provider;

use Geocoder\Model\AddressFactory;
use Geocoder\Provider\AbstractProvider;
use Geocoder\Provider\Provider;

/**
 * Provides a random handler to be used by 'random' plugin.
 */
class Random extends AbstractProvider implements Provider {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'random';
  }

  /**
   * {@inheritdoc}
   */
  public function geocode($data) {
    return (new AddressFactory())->createFromArray([$this->getRandomResult()]);
  }

  /**
   * {@inheritdoc}
   */
  public function reverse($latitude, $longitude) {

  }

  /**
   * Generate a fake random address array.
   *
   * @return array
   */
  protected function getRandomResult() {
    $country = $this->getRandomCountryInfo();
    $streetTypes = array('street', 'avenue', 'square', 'road', 'way', 'drive', 'lane', 'place', 'hill', 'gardens', 'park');

    return array(
      'latitude' => mt_rand(0, 90) + mt_rand() / mt_getrandmax(),
      'longitude' => mt_rand(-180, 180) + mt_rand() / mt_getrandmax(),
      'streetName' => $this->getRandomCountryInfo('name') . ' ' . $streetTypes[mt_rand(0, count($streetTypes) - 1)],
      'streetNumber' => mt_rand(1, 1000),
      'postalCode' => mt_rand(1, 1000),
      'locality' => sha1(mt_rand() / mt_getrandmax()),
      'country' => $country['name'],
      'countryCode' => $country['code'],
    );
  }

  /**
   *
   */
  private function getRandomCountryInfo($type = NULL) {
    $value = [
      'code' => 'BE',
      'name' => 'Belgium',
    ];

    if (is_null($type)) {
      return $value;
    }

    return isset($value[$type]) ? $value[$type] : $value;

    // @todo See how we can use the CountryManager from Drupal to have random country names.
    /*
      $manager = new CountryManager($this->getModuleHandler());
      $countries = $manager->getList();
      uksort($countries, function () {
        return rand() > rand();
      });
      $country = array_slice($countries, 0, 1);

      $value = array(
        'code' => key($country),
        'name' => reset($country),
      );
    */
  }

}

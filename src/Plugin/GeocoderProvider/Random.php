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
 *   "@geocoder.http_adapter",
 *   "@logger.channel.default",
 *   "@messenger"
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
    $cid = $this->getCacheCid($data);

    if ($value = $this->cache_get($cid)) {
      return $value;
    }

    try {
      $value = $this->factory->createFromArray(array($this->getRandomResult()));
      $this->cache_set($cid, $value);
    } catch (\Exception $e) {
      $this->loggerChannel->error($e->getMessage(), array('channel' => 'geocoder'));
      $this->messenger->addMessage($e->getMessage(), 'error', FALSE);
      $value = FALSE;
    }

    return $value;
  }

  public function reverse($latitude, $longitude) {
    $cid = $this->getCacheCid($latitude, $longitude);

    if ($value = $this->cache_get($cid)) {
      return $value;
    }

    try {
      $result = $this->getRandomResult();
      $result['latitude'] = $latitude;
      $result['longitude'] = $longitude;

      $value = $this->factory->createFromArray(array($result));
      $this->cache_set($cid, $value);
    } catch (\Exception $e) {
      $this->loggerChannel->error($e->getMessage(), array('channel' => 'geocoder'));
      $this->messenger->addMessage($e->getMessage(), 'error', FALSE);
      $value = FALSE;
    }

    return $value;
  }

  private function getRandomCountryInfo($type = NULL) {
    include_once DRUPAL_ROOT . '/includes/locale.inc';
    $countries = country_get_list();
    uksort($countries, function() { return rand() > rand(); });
    $country = array_slice($countries, 0, 1);

    $value = array(
      'code' => key($country),
      'name' => reset($country),
    );

    if (is_null($type)) {
      return $value;
    }

    return isset($value[$type]) ? $value[$type] : $value;
  }

  /**
   * Generate a fake random address array.
   *
   * @return array
   */
  private function getRandomResult() {
    $country = $this->getRandomCountryInfo();
    $streetTypes = array('street', 'avenue', 'square', 'road', 'way', 'drive', 'lane', 'place', 'hill', 'gardens', 'park');

    return array(
      'latitude' => mt_rand(0, 90) + mt_rand() / mt_getrandmax(),
      'longitude' => mt_rand(-180, 180) + mt_rand() / mt_getrandmax(),
      'streetName' => $this->getRandomCountryInfo('name') . ' ' . $streetTypes[mt_rand(0, count($streetTypes) -1)],
      'streetNumber' => mt_rand(1, 1000),
      'postalCode' => mt_rand(1, 1000),
      'locality' => sha1(mt_rand()/mt_getrandmax()),
      'country' =>  $country['name'],
      'countryCode' => $country['code'],
    );
  }

}

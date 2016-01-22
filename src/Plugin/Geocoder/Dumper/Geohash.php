<?php
/**
 * @file
 * The Geohash plugin.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Dumper;

use Drupal\geocoder\Plugin\Geocoder\DumperInterface;
use Drupal\geocoder\Plugin\Geocoder\Dumper;
use Geocoder\Model\Address;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Geohash.
 *
 * @GeocoderPlugin(
 *  id = "geohash",
 *  name = "Geohash"
 * )
 */
class Geohash extends Dumper implements DumperInterface {
  /**
   * @inheritDoc
   */
  public function dump(Address $address) {
    $geojson = $this->getGeocoderDumper()->dump($address);
    return \geoPHP::load($geojson, 'json')->out('geohash');
  }

  /**
   * @inheritdoc
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('geocoder.dumper.geojson')
    );
  }

}

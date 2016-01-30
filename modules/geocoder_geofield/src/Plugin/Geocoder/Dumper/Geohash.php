<?php
/**
 * @file
 * The Geohash plugin.
 */

namespace Drupal\geocoder_geofield\Plugin\Geocoder\Dumper;

use Drupal\geocoder\Plugin\Geocoder\DumperInterface;
use Drupal\geocoder\Plugin\Geocoder\DumperBase;
use Drupal\geophp\GeoPHPInterface;
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
class Geohash extends Dumper\GeoJson implements DumperInterface {
  /**
   * @var GeoPHPInterface
   */
  private $geophp;

  /**
   * @inheritDoc
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, \Geocoder\Dumper\Dumper $dumper, GeoPHPInterface $geophp) {
    $this->geophp = $geophp;
    parent::__construct($configuration, $plugin_id, $plugin_definition, $dumper);
  }

  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return array(
      $container,
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('geocoder.dumper.geojson'),
      $container->get('geophp.geophp'),
    );
  }

  /**
   * @inheritDoc
   */
  public function dump(Address $address) {
    return $this->geophp->load(parent::dump($address), 'json')->out('geohash');
  }

}

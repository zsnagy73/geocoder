<?php

/**
 * @file
 * Contains \Drupal\geocoder_geofield\Geocoder\Dumper\Geohash.
 */

namespace Drupal\geocoder_geofield\Geocoder\Dumper;

use Geocoder\Dumper\Dumper;
use Geocoder\Model\Address;
use Drupal\geophp\geoPHPInterface;

/**
 * The Geohash geocoder dumper.
 *
 * @author Pol Dellaiera <pol.dellaiera@gmail.com>
 */
class Geohash implements Dumper {
  /**
   * The Geocoder dumper object.
   *
   * @var \Geocoder\Dumper\Dumper
   */
  protected $dumper;

  /**
   * The Geophp object.
   *
   * @var \Drupal\geophp\geoPHPInterface
   */
  protected $geophp;

  /**
   * {@inheritdoc}
   */
  public function dump(Address $address) {
    return $this->geophp->load($this->dumper->dump($address), 'json')->out('geohash');
  }

  /**
   * {@inheritdoc}
   */
  public function __construct(Dumper $dumper, geoPHPInterface $geophp) {
    $this->dumper = $dumper;
    $this->geophp = $geophp;
  }

}

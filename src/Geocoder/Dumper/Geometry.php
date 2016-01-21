<?php

namespace Drupal\geocoder\Geocoder\Dumper;

use Geocoder\Dumper\Dumper;
use Geocoder\Model\Address;

/**
 * @author Pol Dellaiera <pol.dellaiera@gmail.com>
 */
class Geometry implements Dumper {
  /**
   * @var \Geocoder\Dumper\Dumper
   */
  private $dumper;

  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    return \geoPHP::load($this->dumper->dump($address), 'geojson');
  }

  /**
   * @inheritDoc
   */
  public function __construct(Dumper $dumper) {
    $this->dumper = $dumper;
  }

}

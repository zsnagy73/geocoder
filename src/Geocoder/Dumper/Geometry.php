<?php

namespace Geocoder\Dumper;
use Geocoder\Model\Address;

/**
 * @author Pol Dellaiera <pol.dellaiera@gmail.com>
 */
class Geometry implements Dumper {
  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    $dumper = new \Geocoder\Dumper\GeoJson();
    return \geoPHP::load($dumper->dump($address), 'geojson');
  }

}

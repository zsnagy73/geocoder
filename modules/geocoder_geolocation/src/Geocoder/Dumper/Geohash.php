<?php

namespace Drupal\geocoder_geolocation\Geocoder\Dumper;

use Drupal\geocoder\DumperInterface;
use Drupal\geocoder\DumperPluginManager;
use Geocoder\Dumper\Dumper;
use Geocoder\Model\Address;

class Geohash extends Geometry implements Dumper {
  /**
   * @var \Geocoder\Dumper\Dumper
   */
  protected $dumper;

  /**
   * @inheritdoc
   */
  public function dump(Address $address) {
    return parent::dump($address)->out('geohash');
  }

}

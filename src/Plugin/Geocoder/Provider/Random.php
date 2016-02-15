<?php
/**
 * @file
 * Contains \Drupal\geocoder\Plugin\Geocoder\Provider\Random.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\ProviderBase;

/**
 * The Random plugin.
 *
 * @GeocoderProvider(
 *  id = "random",
 *  name = "Random",
 *  handler = "\Drupal\geocoder\Geocoder\Provider\Random"
 * )
 */
class Random extends ProviderBase {}

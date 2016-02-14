<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\Geocoder\Provider\Geonames.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\ProviderWithHttpAdapterBase;

/**
 * Provides a Geoip geocoder provider plugin.
 *
 * @GeocoderProvider(
 *   id = "geonames",
 *   name = "Geonames",
 *   handler = "\Geocoder\Provider\Geonames",
 *   arguments = {
 *     "username"
 *   }
 * )
 */
class Geonames extends ProviderWithHttpAdapterBase { }

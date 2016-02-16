<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\Geocoder\Provider\FreeGeoIp.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\ProviderWithHttpAdapterBase;

/**
 * Provides a FreeGeoIp geocoder provider plugin.
 *
 * @GeocoderProvider(
 *   id = "freegeoip",
 *   name = "FreeGeoIp",
 *   handler = "\Geocoder\Provider\FreeGeoIp"
 * )
 */
class FreeGeoIp extends ProviderWithHttpAdapterBase {}

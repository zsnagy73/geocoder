<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\Geocoder\Provider\ArcGisOnline.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\ProviderWithHttpAdapterBase;

/**
 * Provides an ArcGISOnline geocoder provider plugin.
 *
 * @GeocoderProvider(
 *   id = "arcgisonline",
 *   name = "ArcGISOnline",
 *   handler = "\Geocoder\Provider\ArcGISOnline",
 *   arguments = {
 *     "sourceCountry"
 *   }
 * )
 */
class ArcGisOnline extends ProviderWithHttpAdapterBase {}

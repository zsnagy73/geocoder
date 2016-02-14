<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\Geocoder\Provider\OpenCage.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\ProviderWithHttpAdapterBase;

/**
 * Provides an OpenCage geocoder provider plugin.
 *
 * @GeocoderProvider(
 *   id = "opencage",
 *   name = "OpenCage",
 *   handler = "",
 *   arguments = {
 *     "apiKey",
 *     "useSsl" = FALSE,
 *     "locale"
 *   }
 * )
 */
class OpenCage extends ProviderWithHttpAdapterBase { }

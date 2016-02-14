<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\Geocoder\Provider\File.
 */

namespace Drupal\geocoder\Plugin\Geocoder\Provider;

use Drupal\geocoder\ProviderBase;

/**
 * Provides a File geocoder provider plugin.
 *
 * @GeocoderPlugin(
 *   id = "file",
 *   name = "File",
 *   handler = "\Drupal\geocoder\Geocoder\Provider\File"
 * )
 */
class File extends ProviderBase { }

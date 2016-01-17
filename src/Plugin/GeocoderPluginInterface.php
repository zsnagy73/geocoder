<?php

namespace Drupal\geocoder\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;

interface GeocoderPluginInterface extends PluginInspectionInterface {
  /**
   * Init method launched after object initialization.
   */
  public function init();

  /**
   * Set the object's configuration.
   *
   * @param array $configuration
   *   The configuration array.
   */
  public function setConfiguration(array $configuration = array());

  /**
   * Get the object's configuration.
   */
  public function getConfiguration();

  /**
   * Get a cache object based on the cache ID.
   *
   * @param string $cid
   *   The cache ID of the data to retrieve.
   *
   * @return \DrupalCacheInterface
   *   The cache object associated to the cache ID.
   *
   * @see cache_set()
   */
  public function cache_get($cid);

  /**
   * Stores data in the persistent cache.
   *
   * The reasons for having several bins are as follows:
   *
   * @param $cid
   *   The cache ID of the data to store.
   * @param $data
   *   The data to store in the cache. Complex data types will be automatically
   *   serialized before insertion. Strings will be stored as plain text and are
   *   not serialized. Some storage engines only allow objects up to a maximum of
   *   1MB in size to be stored by default. When caching large arrays or similar,
   *   take care to ensure $data does not exceed this size.
   *
   * @see cache_set()
   */
  public function cache_set($cid, $data);

  /**
   * Generates a cache ID based on the arguments.
   *
   * @return string
   *   The cache ID.
   */
  public function getCacheCid();

}

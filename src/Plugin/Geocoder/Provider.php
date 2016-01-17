<?php

/**
 * @file
 * Contains \Drupal\geocoder\Plugin\Geocoder\Provider.
 */

namespace Drupal\geocoder\Plugin\Geocoder;

use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\geocoder\Config;
use Drupal\geocoder\Plugin\GeocoderPlugin;
use Drupal\service_container\Messenger\MessengerInterface;
use Ivory\HttpAdapter\HttpAdapterInterface;

class Provider extends GeocoderPlugin implements ProviderInterface {
  /**
   * The messenger service.
   *
   * @var MessengerInterface
   */
  protected $messenger;

  /**
   * The loggerChannel service.
   *
   * @var LoggerChannelInterface
   */
  protected $loggerChannel;

  /**
   * @var HttpAdapterInterface
   */
  private $adapter;

  /**
   * @var \Geocoder\Provider\Provider
   */
  private $handler;

  /**
   * {@inheritdoc}
   */
  public function __construct($configuration, $plugin_id, $plugin_definition, HttpAdapterInterface $adapter, LoggerChannelInterface $logger_channel, MessengerInterface $messenger) {
    $this->loggerChannel = $logger_channel;
    $this->messenger = $messenger;
    $this->adapter = $adapter;
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * The Geocoder Provider.
   *
   * @param \Geocoder\Provider\Provider $handler
   *   The Geocoder provider.
   *
   * @return ProviderInterface
   *   The plugin provider.
   */
  public function setHandler(\Geocoder\Provider\Provider $handler) {
    $this->handler = $handler;

    return $this;
  }

  /**
   * Get the Geocoder handler.
   *
   * @return \Geocoder\Provider\Provider
   */
  public function getHandler() {
    return $this->handler;
  }

  /**
   * Returns the HTTP adapter.
   *
   * @return HttpAdapterInterface
   */
  public function getAdapter() {
    return $this->adapter;
  }

  /**
   * {@inheritdoc}
   */
  public function geocode($data) {
    $cid = $this->getCacheCid($data);

    if ($value = $this->cache_get($cid)) {
      return $value;
    }

    try {
      $value = $this->getHandler()->geocode($data);
    } catch (\Exception $e) {
      throw $e;
    } catch (\InvalidCredentials $e) {
      throw $e;
    }

    $this->cache_set($cid, $value);

    return $value;
  }

  /**
   * {@inheritdoc}
   */
  public function reverse($latitude, $longitude) {
    $cid = $this->getCacheCid($latitude, $longitude);

    if ($value = $this->cache_get($cid)) {
      return $value;
    }

    try {
      $value = $this->getHandler()->reverse($latitude, $longitude);
    } catch (\Exception $e) {
      throw $e;
    }

    $this->cache_set($cid, $value);

    return $value;
  }

}

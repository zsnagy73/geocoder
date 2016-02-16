<?php

/**
 * @file
 * Contains \Drupal\geocoder\ProviderBase.
 */

namespace Drupal\geocoder;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\PluginBase;
use Geocoder\Exception\InvalidCredentials;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a base class for providers using handlers.
 */
abstract class ProviderBase extends PluginBase implements ProviderInterface, ContainerFactoryPluginInterface {

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The cache backend used to cache geocoding data.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $cacheBackend;

  /**
   * The provider handler.
   *
   * @var \Geocoder\Provider\Provider
   */
  protected $handler;

  /**
   * Constructs a geocoder provider plugin object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   The cache backend used to cache geocoding data.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, CacheBackendInterface $cache_backend) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->cacheBackend = $cache_backend;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('cache.geocoder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function geocode($data) {
    return $this->process(__FUNCTION__, func_get_args());
  }

  /**
   * {@inheritdoc}
   */
  public function reverse($latitude, $longitude) {
    return $this->process(__FUNCTION__, func_get_args());
  }

  /**
   * Provides a helper callback for geocode() and reverse().
   *
   * @param string $method
   *   The method: 'geocode' or 'reverse'.
   * @param array $data
   *   An array with data to be processed. When geocoding, it contains only one
   *   item with the string. When reversing, contains 2 items: the latitude and
   *   the longitude.
   *
   * @return \Geocoder\Model\Address|null
   *
   * @throws \Exception
   */
  protected function process($method, array $data) {
    if ($caching = $this->configFactory->get('geocoder.settings')->get('cache')) {
      // Try to retrieve from cache first.
      $cid = $this->getCacheId($method, $data);
      if ($cache = $this->cacheBackend->get($cid)) {
        return $cache->data;
      }
    }

    try {
      // Perform geocoding.
      $value = call_user_func_array([$this->getHandler(), $method], $data);
    }
    catch (InvalidCredentials $e) {
      throw new InvalidCredentials($e->getMessage());
    }
    catch (\Exception $e) {
      throw $e;
    }

    if ($caching) {
      // Cache the result.
      $this->cacheBackend->set($cid, $value);
    }

    return $value;
  }

  /**
   * Builds a cached id.
   *
   * @param string $method
   *   The method: 'geocode' or 'reverse'.
   * @param array $data
   *   An array with data to be processed. When geocoding, it contains only one
   *   item with the string. When reversing, contains 2 items: the latitude and
   *   the longitude.
   *
   * @return string
   *   An unique cache id.
   */
  protected function getCacheId($method, array $data) {
    $cid = [$method, $this->getPluginId()];
    $cid[] = sha1(serialize($this->configuration) . serialize($data));
    return implode(':', $cid);
  }


  /**
   * Returns the provider handler.
   *
   * @return \Geocoder\Provider\Provider
   */
  protected function getHandler() {
    if (!isset($this->handler)) {
      $definition = $this->getPluginDefinition();
      $reflection_class = new \ReflectionClass($definition['handler']);
      $this->handler = $reflection_class->newInstanceArgs($this->getArguments());
    }

    return $this->handler;
  }

  /**
   * Builds a list of arguments to be used by the handler.
   *
   * @return array
   *   The list of arguments for handler instantiation.
   */
  protected function getArguments() {
    $arguments = [];
    foreach ($this->getPluginDefinition()['arguments'] as $key => $argument) {
      // No default value has been passed.
      if (is_string($key)) {
        $config_name = $key;
        $default_value = $argument;
      }
      else {
        $config_name = $argument;
        $default_value = NULL;
      }
      $arguments[] = isset($this->configuration[$config_name]) ? $this->configuration[$config_name] : $default_value;
    }
    return $arguments;
  }

}

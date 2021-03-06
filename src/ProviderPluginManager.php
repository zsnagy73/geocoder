<?php

namespace Drupal\geocoder;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\geocoder\Annotation\GeocoderProvider;
use Drupal\Core\Serialization\Yaml;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Url;
use Drupal\Core\Utility\LinkGeneratorInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;

/**
 * Provides a plugin manager for geocoder providers.
 */
class ProviderPluginManager extends GeocoderPluginManagerBase {

  use StringTranslationTrait;

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   * The Renderer service property.
   *
   * @var \Drupal\Core\Entity\EntityDisplayRepositoryInterface
   */
  protected $renderer;

  /**
   * The Link generator Service.
   *
   * @var \Drupal\Core\Utility\LinkGeneratorInterface
   */
  protected $link;

  /**
   * Constructs a new geocoder provider plugin manager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations,.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   The cache backend to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   A config factory for retrieving required config objects.
   * @param \Drupal\Core\StringTranslation\TranslationInterface $string_translation
   *   The string translation service.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer.
   * @param \Drupal\Core\Utility\LinkGeneratorInterface $link_generator
   *   The Link Generator service.
   */
  public function __construct(
    \Traversable $namespaces,
    CacheBackendInterface $cache_backend,
    ModuleHandlerInterface $module_handler,
    ConfigFactoryInterface $config_factory,
    TranslationInterface $string_translation,
    RendererInterface $renderer,
    LinkGeneratorInterface $link_generator
  ) {
    parent::__construct('Plugin/Geocoder/Provider', $namespaces, $module_handler, ProviderInterface::class, GeocoderProvider::class);
    $this->alterInfo('geocoder_provider_info');
    $this->setCacheBackend($cache_backend, 'geocoder_provider_plugins');

    $this->config = $config_factory->get('geocoder.settings');
    $this->stringTranslation = $string_translation;
    $this->renderer = $renderer;
    $this->link = $link_generator;

  }

  /**
   * Generates the Draggable Table of Selectable Geocoder Plugins.
   *
   * @param array $enabled_plugins
   *   The list of the enabled plugins machine names.
   *
   * @return array
   *   The plugins table list.
   */
  public function providersPluginsTableList(array $enabled_plugins) {
    $geocoder_settings_link = $this->link->generate(t('Edit options in the Geocoder configuration page</span>'), Url::fromRoute('geocoder.settings', [], [
      'query' => [
        'destination' => Url::fromRoute('<current>')
          ->toString(),
      ],
    ]));

    $options_field_description = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('Object literals in YAML format. @geocoder_settings_link', [
        '@geocoder_settings_link' => $geocoder_settings_link ,
      ]),
      '#attributes' => [
        'class' => [
          'options-field-description',
        ],
      ],
    ];

    $caption = [
      'title' => [
        '#type' => 'html_tag',
        '#tag' => 'label',
        '#value' => $this->t('Geocoder plugin(s)'),
      ],
      'caption' => [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#value' => $this->t('Select the Geocoder plugins to use, you can reorder them. The first one to return a valid value will be used.'),
      ],
    ];

    $element['plugins'] = [
      '#type' => 'table',
      '#header' => [
        $this->t('Name'),
        $this->t('Weight'),
        $this->t('Options<br>@options_field_description', [
          '@options_field_description' => $this->renderer->renderRoot($options_field_description),
        ]),
      ],
      '#tabledrag' => [[
        'action' => 'order',
        'relationship' => 'sibling',
        'group' => 'plugins-order-weight',
      ],
      ],
      '#caption' => $this->renderer->renderRoot($caption),
      // We need this class for #states to hide the entire table.
      '#attributes' => ['class' => ['js-form-item', 'geocode-plugins-list']],
    ];

    // Reorder the plugins promoting the default ones in the proper order.
    $plugins = array_combine($enabled_plugins, $enabled_plugins);
    foreach ($this->getPlugins() as $plugin) {
      // Non-default values are appended at the end.
      $plugins[$plugin['id']] = $plugin;
    }

    $plugins = array_map(function ($plugin, $weight) use ($enabled_plugins) {
      return array_merge($plugin, [
        'checked' => in_array($plugin['id'], $enabled_plugins),
        'weight' => $weight,
        'settings' => (empty($plugin['settings']) ? (string) $this->t("This plugin don't accept arguments.") : Yaml::encode($plugin['settings'])),
      ]);
    }, $plugins, range(0, count($plugins) - 1));

    uasort($plugins, function ($pluginA, $pluginB) {
      $order = strcmp($pluginB['checked'], $pluginA['checked']);

      if (0 === $order) {
        $order = $pluginA['weight'] - $pluginB['weight'];

        if (0 === $order) {
          $order = strcmp($pluginA['name'], $pluginB['name']);
        }
      }

      return $order;
    });

    foreach ($plugins as $plugin) {
      $element['plugins'][$plugin['id']] = [
        'checked' => [
          '#type' => 'checkbox',
          '#title' => $plugin['name'],
          '#default_value' => $plugin['checked'],
        ],
        'weight' => [
          '#type' => 'weight',
          '#title' => $this->t('Weight for @title', ['@title' => $plugin['name']]),
          '#title_display' => 'invisible',
          '#default_value' => $plugin['weight'],
          '#delta' => 20,
          '#attributes' => ['class' => ['plugins-order-weight']],
        ],
        'settings' => [
          '#type' => 'html_tag',
          '#tag' => 'pre',
          '#value' => $plugin['settings'],
        ],
        '#attributes' => ['class' => ['draggable']],
      ];
    }

    return $element['plugins'];
  }

}

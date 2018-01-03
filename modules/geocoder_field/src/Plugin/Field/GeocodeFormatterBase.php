<?php

namespace Drupal\geocoder_field\Plugin\Field;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\geocoder\DumperPluginManager;
use Drupal\geocoder\Geocoder;
use Drupal\geocoder\ProviderPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base Plugin implementation of the Geocode formatter.
 */
abstract class GeocodeFormatterBase extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * The geocoder service.
   *
   * @var \Drupal\geocoder\ProviderPluginManager
   */
  protected $geocoder;

  /**
   * The provider plugin manager service.
   *
   * @var \Drupal\geocoder\ProviderPluginManager
   */
  protected $providerPluginManager;

  /**
   * The dumper plugin manager service.
   *
   * @var \Drupal\geocoder\DumperPluginManager
   */
  protected $dumperPluginManager;

  /**
   * Constructs a GeocodeFormatterBase object.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\geocoder\Geocoder $geocoder
   *   The gecoder service.
   * @param \Drupal\geocoder\ProviderPluginManager $provider_plugin_manager
   *   The provider plugin manager service.
   * @param \Drupal\geocoder\DumperPluginManager $dumper_plugin_manager
   *   The dumper plugin manager service.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, Geocoder $geocoder, ProviderPluginManager $provider_plugin_manager, DumperPluginManager $dumper_plugin_manager) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->geocoder = $geocoder;
    $this->providerPluginManager = $provider_plugin_manager;
    $this->dumperPluginManager = $dumper_plugin_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('geocoder'),
      $container->get('plugin.manager.geocoder.provider'),
      $container->get('plugin.manager.geocoder.dumper')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return parent::defaultSettings() + [
      'dumper_plugin' => 'wkt',
      'provider_plugins' => [],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $enabled_plugins = [];
    $i = 0;
    foreach ($this->getSetting('provider_plugins') as $plugin_id => $plugin) {
      if ($plugin['checked']) {
        $plugin['weight'] = intval($i++);
        $enabled_plugins[$plugin_id] = $plugin;
      }
    }

    $elements['geocoder_plugins_title'] = [
      '#type' => 'item',
      '#weight' => 15,
      '#title' => t('Geocoder plugin(s)'),
      '#description' => t('Select the Geocoder plugins to use, you can reorder them. The first one to return a valid value will be used.'),
    ];

    $elements['provider_plugins'] = [
      '#type' => 'table',
      '#weight' => 20,
      '#header' => [
        ['data' => $this->t('Enabled')],
        ['data' => $this->t('Weight')],
        ['data' => $this->t('Name')],
      ],
      '#tabledrag' => [
        [
          'action' => 'order',
          'relationship' => 'sibling',
          'group' => 'provider_plugins-order-weight',
        ],
      ],
    ];

    $rows = [];
    $count = count($enabled_plugins);
    foreach ($this->providerPluginManager->getPluginsAsOptions() as $plugin_id => $plugin_name) {
      if (isset($enabled_plugins[$plugin_id])) {
        $weight = $enabled_plugins[$plugin_id]['weight'];
      }
      else {
        $weight = $count++;
      }

      $rows[$plugin_id] = [
        '#attributes' => [
          'class' => ['draggable'],
        ],
        '#weight' => $weight,
        'checked' => [
          '#type' => 'checkbox',
          '#default_value' => isset($enabled_plugins[$plugin_id]) ? 1 : 0,
        ],
        'weight' => [
          '#type' => 'weight',
          '#title' => t('Weight for @title', ['@title' => $plugin_id]),
          '#title_display' => 'invisible',
          '#default_value' => $weight,
          '#attributes' => ['class' => ['provider_plugins-order-weight']],
        ],
        'name' => [
          '#plain_text' => $plugin_name,
        ],
      ];
    }

    uasort($rows, function ($a, $b) {
      return strcmp($a['#weight'], $b['#weight']);
    });

    foreach ($rows as $plugin_id => $row) {
      $elements['provider_plugins'][$plugin_id] = $row;
    }

    $elements['dumper_plugin'] = [
      '#type' => 'select',
      '#weight' => 25,
      '#title' => 'Output format',
      '#default_value' => $this->getSetting('dumper_plugin'),
      '#options' => $this->dumperPluginManager->getPluginsAsOptions(),
      '#description' => t('Set the output format of the value. Ex, for a geofield, the format must be set to WKT.'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $provider_plugin_ids = $this->getEnabledProviderPlugins();
    $dumper_plugins = $this->dumperPluginManager->getPluginsAsOptions();
    $dumper_plugin = $this->getSetting('dumper_plugin');

    $summary[] = t('Geocoder plugin(s): @plugin_ids', [
      '@plugin_ids' => !empty($provider_plugin_ids) ? implode(', ', $provider_plugin_ids) : $this->t('Not yet set'),
    ]);

    $summary[] = t('Output format plugin: @format', [
      '@format' => !empty($dumper_plugin) ? $dumper_plugins[$dumper_plugin] : $this->t('Not yet set'),
    ]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $dumper = $this->dumperPluginManager->createInstance($this->getSetting('dumper_plugin'));
    $provider_plugins = $this->getEnabledProviderPlugins();

    foreach ($items as $delta => $item) {
      if ($addressCollection = $this->geocoder->geocode($item->value, array_keys($provider_plugins))) {
        $elements[$delta] = [
          '#plain_text' => $dumper->dump($addressCollection->first()),
        ];
      }
    }

    return $elements;
  }

  /**
   * Get the list of enabled Provider plugins.
   *
   * @return array
   *   Provider plugin IDs.
   */
  public function getEnabledProviderPlugins() {
    $provider_plugin_ids = [];
    $geocoder_plugins = $this->providerPluginManager->getPluginsAsOptions();

    foreach ($this->getSetting('provider_plugins') as $plugin_id => $plugin) {
      if ($plugin['checked']) {
        $provider_plugin_ids[$plugin_id] = $geocoder_plugins[$plugin_id];
      }
    }

    return $provider_plugin_ids;
  }

}

<?php

namespace Drupal\geocoder\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Utility\LinkGeneratorInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\geocoder\ProviderPluginManager;
use Drupal\Core\Url;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Render\RendererInterface;

/**
 * The geocoder settings form.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * The Link generator Service.
   *
   * @var \Drupal\Core\Utility\LinkGeneratorInterface
   */
  protected $link;

  /**
   * The language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The Renderer service property.
   *
   * @var \Drupal\Core\Entity\EntityDisplayRepositoryInterface
   */
  protected $renderer;

  /**
   * The provider plugin manager service.
   *
   * @var \Drupal\geocoder\ProviderPluginManager
   */
  protected $providerPluginManager;

  /**
   * GeofieldMapSettingsForm constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Utility\LinkGeneratorInterface $link_generator
   *   The Link Generator service.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   * @param \Drupal\geocoder\ProviderPluginManager $provider_plugin_manager
   *   The provider plugin manager service.
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    LinkGeneratorInterface $link_generator,
    RendererInterface $renderer,
    LanguageManagerInterface $language_manager,
    ProviderPluginManager $provider_plugin_manager
  ) {
    parent::__construct($config_factory);
    $this->link = $link_generator;
    $this->renderer = $renderer;
    $this->languageManager = $language_manager;
    $this->providerPluginManager = $provider_plugin_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {

    return new static(
      $container->get('config.factory'),
      $container->get('link_generator'),
      $container->get('renderer'),
      $container->get('language_manager'),
      $container->get('plugin.manager.geocoder.provider')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'geocoder_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('geocoder.settings');

    // Attach Geofield Map Library.
    $form['#attached']['library'] = [
      'geocoder_field/general',
    ];

    $form['cache'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Should we cache the results?'),
      '#description' => $this->t('To prevent sending multiple times the same request, you can enable to cache to save temporarly the result of the geocode and reverse geocode in the cache.'),
      '#default_value' => $config->get('cache'),
    ];

    $geocoder_php_library_link = $this->link->generate(t('Geocoder Php Library'), Url::fromUri('http://geocoder-php.org/Geocoder/#address-based-providers', [
      'absolute' => TRUE,
      'attributes' => ['target' => 'blank'],
    ]));

    $form['geocoder_plugins_title'] = [
      '#type' => 'item',
      '#title' => t('Geocoder plugin(s) Options'),
      '#description' => t('Set the Options to be used on your plugins. As a good help it is possible to refer to the requirements listed in the @geocoder_php_library_link documentation.', [
        '@geocoder_php_library_link' => $geocoder_php_library_link,
      ]),
    ];

    $form['plugins'] = [
      '#type' => 'table',
      '#weight' => 20,
      '#header' => [
        $this->t('Geocoder plugins'),
        $this->t('Options / Arguments'),
      ],
      '#attributes' => [
        'class' => [
          'geocode-plugins-list',
        ],
      ],
    ];

    $rows = [];
    foreach ($this->providerPluginManager->getPlugins() as $plugin) {
      $rows[$plugin['id']] = [
        'name' => [
          '#plain_text' => $plugin['name'],
        ],
      ];

      // Expose an Options Field if the Plugin accepts arguments.
      if (!empty($plugin['arguments'])) {
        foreach ($plugin['arguments'] as $option_key => $value) {
          $plugin['arguments'] += [$option_key => $value];

          if (is_bool($value)) {
            // If the argument is boolean generate a checkbox field.
            $rows[$plugin['id']]['options'][$option_key] = [
              '#type' => 'checkbox',
              '#title' => $option_key,
              '#default_value' => $plugin['arguments'][$option_key],
            ];
          }
          else {
            // Handle args without values.
            if (!is_string($option_key)) {
              $option_key = $value;
              $value = NULL;
            }

            // A textfield field otherwise.
            $rows[$plugin['id']]['options'][$option_key] = [
              '#type' => 'textfield',
              '#size' => 50,
              '#title' => $option_key,
              '#default_value' => $plugin['arguments'][$option_key],
            ];
          }
        }
      }
      else {
        $rows[$plugin['id']]['options'] = [
          '#type' => 'value',
          '#value' => [],
          'notes' => [
            '#type' => 'html_tag',
            '#tag' => 'div',
            '#value' => $this->t("This plugin doesn't accept arguments."),
            '#attributes' => [
              'class' => [
                'options-notes',
              ],
            ],
          ],
        ];
      }

      // Customize the Row Plugin Options based on the Plugin Id.
      $rows[$plugin['id']] = $this->pluginRowCustomize($rows[$plugin['id']], $plugin['id'], $plugin['arguments']);
    }

    foreach ($rows as $plugin_id => $row) {
      $form['plugins'][$plugin_id] = $row;
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get all the form state values, in an array structure.
    $form_state_values = $form_state->getValues();

    $plugins_options = [];
    foreach ($form_state_values['plugins'] as $k => $plugin) {
      $plugins_options[$k] = $form_state_values['plugins'][$k]['options'];
    }

    $this->config('geocoder.settings')->set('cache', $form_state_values['cache']);
    $this->config('geocoder.settings')->set('plugins_options', Json::encode($plugins_options));
    $this->config('geocoder.settings')->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['geocoder.settings'];
  }

  /**
   * Eventually Customize the Row Plugin Options based on the Plugin Id.
   *
   * @param array $row
   *   The Row.
   * @param string $plugin_id
   *   The Plugin id.
   * @param array $plugins_options
   *   The Plugin options array.
   *
   * @return array
   *   The altered row.
   */
  private function pluginRowCustomize(array $row, $plugin_id, array $plugins_options) {
    switch ($plugin_id) {
      case 'googlemaps':
        if (empty($plugins_options[$plugin_id]['apiKey'])) {
          $row['options']['googlemaps_notes'] = [
            '#type' => 'html_tag',
            '#tag' => 'div',
            '#value' => $this->t('@gmap_api_key_link', [
              '@gmap_api_key_link' => $this->link->generate($this->t('Get a valid Google Maps Api Key'), Url::fromUri('https://developers.google.com/maps/documentation/javascript/get-api-key', [
                'absolute' => TRUE,
                'attributes' => ['target' => 'blank'],
              ])),
            ]),
          ];
        }
        break;

      default:
    }

    return $row;
  }

}

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
    $language_id = $this->languageManager->getCurrentLanguage()->getId();

    // Attach Geofield Map Library.
    $form['#attached']['library'] = [
      'geocoder_field/general',
    ];

    $form['cache'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Should we cache the results?'),
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

    $options_field_description = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('An object literal of Geocoder options.<u> The syntax should respect the javascript object notation (json) format.</u><br>As suggested always use double quotes (") both for the indexes and the string values.'),
      '#attributes' => [
        'class' => [
          'options-field-description',
        ],
      ],
    ];

    // Define default placeholder for the options field.
    $options_field_placeholder = '{"locale":"' . $language_id . '", "key_2": "value_2", "key_n": "value_n"}';

    $form['provider_plugins'] = [
      '#type' => 'table',
      '#weight' => 20,
      '#header' => [
        $this->t('Geocoder plugins'),
        $this->t('Options<br>@options_field_description', [
          '@options_field_description' => $this->renderer->renderRoot($options_field_description),
        ]),
      ],
      '#attributes' => [
        'class' => [
          'geocode-formatter',
        ],
      ],
    ];

    $plugins_options = Json::decode($config->get('plugins_options'));

    $rows = [];
    foreach ($this->providerPluginManager->getPluginsAsOptions() as $plugin_id => $plugin_name) {
      $rows[$plugin_id] = [
        'name' => [
          '#plain_text' => $plugin_name,
        ],
        'options' => [
          '#type' => 'container',
          'json_options' => [
            '#type' => 'textarea',
            '#title' => $this->t('@title Options', ['@title' => $plugin_name]),
            '#title_display' => 'invisible',
            '#rows' => 2,
            '#default_value' => isset($plugins_options[$plugin_id]) ? $plugins_options[$plugin_id] : '',
            '#placeholder' => $options_field_placeholder,
            '#element_validate' => [[get_class($this), 'jsonValidate']],
          ],
        ],
      ];

      // Customize the Plugin Options Row based on the Plugin Id.
      $rows[$plugin_id] = $this->pluginRowCustomize($rows[$plugin_id], $plugin_id, $plugins_options);

    }

    foreach ($rows as $plugin_id => $row) {
      $form['provider_plugins'][$plugin_id] = $row;
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
    foreach ($form_state_values['provider_plugins'] as $k => $plugin) {
      $plugins_options[$k] = $form_state_values['provider_plugins'][$k]['options']['json_options'];
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
   * Form element json format validation handler.
   *
   * {@inheritdoc}
   */
  public static function jsonValidate($element, FormStateInterface &$form_state) {
    $element_values_array = JSON::decode($element['#value']);
    // Check the jsonValue.
    if (!empty($element['#value']) && $element_values_array == NULL) {
      $form_state->setError($element, t('The @field field is not valid Json Format.', ['@field' => $element['#title']]));
    }
    elseif (!empty($element['#value'])) {
      $form_state->setValueForElement($element, JSON::encode($element_values_array));
    }
  }

  /**
   * Customize the Plugin Options Row based on the Plugin Id.
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

    $language_id = $this->languageManager->getCurrentLanguage()->getId();

    switch ($plugin_id) {

      case 'googlemaps':
        $row['options']['json_options']['#placeholder'] = $this->t('{"apiKey": "[a_valid_google_maps_api_key]", "useSsl": 1, "locale":"@language_id", "key_n": "value_n"}', [
          '@language_id' => $language_id,
        ]);
        if (empty(Json::decode($plugins_options[$plugin_id])['apiKey'])) {
          $row['options']['json_options_notes'] = [
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

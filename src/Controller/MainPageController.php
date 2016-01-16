<?php

namespace Drupal\geocoder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\geocoder\Geocoder;

class MainPageController extends ControllerBase {

  public function mainPage() {
    $type = \Drupal::service('plugin.manager.geocoder.provider');
    $plugin_definitions = $type->getDefinitions();
    $content = print_r($plugin_definitions, 1);

    $type = \Drupal::service('plugin.manager.geocoder.dumper');
    $plugin_definitions = $type->getDefinitions();
    $content .= print_r($plugin_definitions, 1);

    return [
      '#markup' => '<pre>' . $content . '</pre>',
    ];
  }

}
<?php

/**
 * Return capabilities of the Geocoder service.
 *
 * @return \stdClass
 */
function geocoder_services_services_capabilities() {
  $object = new stdClass();
  $object->plugins = array_values(\Drupal\geocoder\Geocoder::getProviderPlugins());
  $object->output = array_values(\Drupal\geocoder\Geocoder::getDumperPlugins());
  return $object;
}

/**
 * Callback for Geocoding service
 *
 * @param string $plugin_id
 * @param string $data
 * @param string $output (optional)
 *
 * @return object
 */
function geocoder_services_geocoder_geocode_callback($plugin_id, $data, $output) {
  geocoder_services_check_request($plugin_id, $output);

  if ($addressCollection = \Drupal\geocoder\Geocoder::geocode($plugin_id, $data)) {
    $data = array(
      'count' => $addressCollection->count(),
    );

    foreach($addressCollection as $address) {
      $data['collection'][] = array(
        'raw' => $address->toArray(),
        'formatted' => \Drupal::service('geocoder.Dumper')->createInstance($output)->dump($address),
      );
    }
  } else {
    $data = array(
      'count' => 0
    );
  }

  return $data;
}

/**
 * Callback for Revere Geocoding service
 *
 * @param string $plugin_id
 * @param string $data
 * @param string $output (optional)
 *
 * @return object
 */
function geocoder_services_geocoder_reverse_callback($plugin_id, $data, $output) {
  geocoder_services_check_request($plugin_id, $output);
  list($latitude, $longitude) = explode(',', $data, 2);

  if ($addressCollection = \Drupal\geocoder\Geocoder::reverse($plugin_id, $latitude, $longitude)) {
    $data = array(
      'count' => $addressCollection->count(),
    );

    foreach($addressCollection as $address) {
      $data['collection'][] = array(
        'raw' => $address->toArray(),
        'formatted' => \Drupal::service('geocoder.Dumper')->createInstance($output)->dump($address),
      );
    }
  } else {
    $data = array(
      'count' => 0
    );
  }

  return $data;
}

/**
 * Access control callback for the service resource: retrieve.
 *
 * @param $plugin_id
 * @param $data
 * @param $output
 *
 * @return bool
 */
function geocoder_services_services_access($plugin_id, $data, $output) {
  return geocoder_services_check_perms($plugin_id);
}

/**
 * Access control callback for the service resource: index.
 *
 * @return bool
 */
function geocoder_services_services_capabilities_ac() {
  return TRUE;
}

/**
 * Geocoder Services Check Request
 *
 * Check to make sure the request to the service is valid. This
 * checks to make sure the plugin and the format exists, and
 * also checks permission
 */
function geocoder_services_check_request($plugin_id, $output) {
  if (!geocoder_services_check_perms($plugin_id)) {
    drupal_access_denied();
    drupal_exit();
  }

  if (!(\Drupal::service('geocoder.Provider')->hasDefinition($plugin_id))) {
    drupal_set_message(t('Could not find provider plugin @plugin_id', array('@plugin_id' => $plugin_id)), 'error');
    drupal_not_found();
    drupal_exit();
  }

  if (!(\Drupal::service('geocoder.Dumper')->hasDefinition($output))) {
    drupal_set_message(t('Could not find dumper plugin @plugin_id', array('@plugin_id' => $output)), 'error');
    drupal_not_found();
    drupal_exit();
  }
}

/**
 * Geocoder Services check permissions
 *
 * Given a plugin, check to see if the user has
 * permission to execute it via AJAX / services
 */
function geocoder_services_check_perms($plugin_id) {
  return (user_access('bypass_geocoder_services_access') || user_access('geocoder_services_plugin_' . $plugin_id));
}

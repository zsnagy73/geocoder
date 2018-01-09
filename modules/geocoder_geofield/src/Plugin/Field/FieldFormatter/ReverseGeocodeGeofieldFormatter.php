<?php

namespace Drupal\geocoder_geofield\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\geocoder_field\Plugin\Field\GeocodeFormatterBase;
use Drupal\Component\Serialization\Json;

/**
 * Plugin implementation of the Geocode formatter.
 *
 * @FieldFormatter(
 *   id = "geocoder_geofield_reverse_geocode",
 *   label = @Translation("Reverse geocode"),
 *   field_types = {
 *     "geofield",
 *   }
 * )
 */
class ReverseGeocodeGeofieldFormatter extends GeocodeFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    /* @var \Drupal\geofield\GeoPHP\GeoPHPInterface */
    $geophp = \Drupal::service('geofield.geophp');
    $provider_plugins = $this->getEnabledProviderPlugins();
    $geocoder_plugins_options = Json::decode($this->config->get('plugins_options'));

    foreach ($items as $delta => $item) {
      /** @var \Geometry $geom */
      $geom = $geophp->load($item->value);
      /** @var \Point $centroid */
      $centroid = $geom->getCentroid();
      if ($address_collection = $this->geocoder->reverse($centroid->y(), $centroid->x(), array_keys($provider_plugins), $geocoder_plugins_options)) {
        // @TODO This should be generated from the Formatter (to be created) instead.
        $elements[$delta] = [
          '#markup' => $this->dumperPluginManager->createInstance($this->getSetting('dumper'))->dump($address_collection->first()),
        ];
      }
    }

    return $elements;
  }

}

<?php

namespace Drupal\geocoder_geofield\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\geocoder_field\Plugin\Field\GeocodeFormatterBase;

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

    foreach ($items as $delta => $item) {
      /** @var \Geometry $geom */
      $geom = $geophp->load($item->value);
      /** @var \Point $centroid */
      $centroid = $geom->getCentroid();
      if ($address_collection = $this->geocoder->reverse($centroid->y(), $centroid->x(), array_keys($provider_plugins))) {
        // @TODO This should be generated from the Formatter (to be created) instead.
        $elements[$delta] = [
          '#markup' => $this->dumperPluginManager->createInstance($this->getSetting('dumper_plugin'))->dump($address_collection->first()),
        ];
      }
    }

    return $elements;
  }

}

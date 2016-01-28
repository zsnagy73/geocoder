<?php
/**
 * @file
 * The Wkt plugin.
 */

namespace Drupal\geocoder_geofield\Plugin\Geocoder\InputFormat;

use Drupal\Core\Form\FormStateInterface;
use Drupal\geocoder\Plugin\Geocoder\InputFormat;
use Drupal\geocoder\Plugin\Geocoder\InputFormatInterface;
use Drupal\geophp\GeoPHPInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Wkt.
 *
 * @GeocoderPlugin(
 *  id = "wkt",
 *  name = "WKT"
 * )
 */
class Wkt extends InputFormat implements InputFormatInterface {
  /**
   * @var GeoPHPInterface
   */
  private $geophp;

  /**
   * @inheritDoc
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, GeoPHPInterface $geophp) {
    $this->geophp = $geophp;
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return array(
      $container,
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('geophp.geophp')
    );
  }

  /**
   * @inheritdoc
   */
  public function massageFormValues(array $values = array(), array $form, FormStateInterface $form_state) {
    foreach ($values as $index => $value) {
      if ($geometry = $this->geophp->load($value['value'], 'wkt')) {
        $values[$index] += array(
          'lat' => $geometry->getCentroid()->y(),
          'lon' => $geometry->getCentroid()->x(),
        );
      }
    }

    return $values;
  }
}

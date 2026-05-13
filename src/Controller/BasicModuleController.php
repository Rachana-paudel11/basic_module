<?php

namespace Drupal\basic_module\Controller;

use Drupal\Core\Controller\ControllerBase;

class BasicModuleController extends ControllerBase {

  public function page() {
    return [
      '#markup' => 'Hello from Basic Drupal Module',
    ];
  }

}

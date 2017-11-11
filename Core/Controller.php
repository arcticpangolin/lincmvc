<?php

/**

  TODO:
  - Add better notes
  - Add namespace and use
  - Add core controller functions (auth?)

 */

namespace Core;

/**
* base controller
*/
abstract class Controller
{
  /**
  
    TODO:
    - Add notes to everything
    - clean up
  
   */
  
  protected $route_params = [];

  public function __construct($route_params) {
    $this->route_params = $route_params;
  }
}
<?php

/**

  TODO:
  - Add better notes
  - Add namespace and use (name space done - now using views)
  - Add core controller functions (auth?)
  - Organize them...

 */

namespace Core;

use \Core\View;

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

  /**
  
    TODO:
    - note below the call magic method use
    - all controller action functions must follow the {name}Action convention
    - they must be called without the action suffix
    - also comment on protected helper functions
  
   */
  

  public function __call($name, $args) {
    $method = $name . 'Action';

    if (method_exists($this, $method)) {
      if ($this->before() !== false) {
        call_user_func_array([$this, $method], $args);
        $this->after();
      }
    } else {
        echo "Mthod $method not found in contoller " . get_class($this);
    }
  }

  protected function before() {
    # blank slate
    # return false in before() method on controller to prevent the execution of the called action (auth)
  }

  protected function after() {
    # blank slate
  }
}
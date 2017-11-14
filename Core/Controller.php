<?php

/**
* Core View
*
* PHP 7
* Written by John Lincoln 2017
*/

namespace Core;

use \Core\View;

abstract class Controller
{

  /**
   *
   * parameters from the matched route
   * @var array
   */
  
  protected $route_params = [];

  /**
   *
   * Function __construct - class constructor
   *
   * @param array $route_params - parameters from the matched route
   *
   * @return void
   */
  

  public function __construct($route_params) {
    $this->route_params = $route_params;
  }
  
  /**
   *
   * Function __call - PHP Magic method
   * called when a bad method is called on a Core Controller object as
   * well as allow for the implementation of action filters.
   * 
   * ALL actions must include the suffix Action - e.g. indexAction
   * 
   * @param string $name - method name
   * @param array $args - args passed to the method
   *
   * @return void
   */

  public function __call($name, $args) {
    $method = $name . 'Action';

    if (method_exists($this, $method)) {
      if ($this->before() !== false) {
        call_user_func_array([$this, $method], $args);
        $this->after();
      }
    } else {
      throw new \Exception("Method $method not found in controller " . get_class($this));
    }
  }

  /**
   *
   * Function before - action filter
   * called before the execution of the controller action
   * 
   * @return void
   */

  protected function before() {
    # blank slate
    # return false in before() method on controller to prevent the execution of the called action (auth)
  }

  /**
   *
   * Function after - action filter
   * called after the execution of the controller action
   * 
   * @return void
   */

  protected function after() {
    # blank slate
  }
}
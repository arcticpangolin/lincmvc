<?php

/**
* Router
*
* PHP 7
* Written by John Lincoln 2017
*/

class Router
{

  /**
  *
  * routing table
  * @var array
  */

  protected $routes = [];

  /**
   *
   * parameters from matched route
   * @var array
   */
  
  protected $params = [];

  /**
  *
  * add routes to routing table
  * @param string $route - Route URL
  * @param array $params - Parameters (controller/action/yadda)
  *
  * @return void
  */

  public function add($route, $params = []) {
    # convert route to regex
    $route = preg_replace('/\//', '\\/', $route);

    # convert vars - example: {controller}/{action}
    $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

    # add vars with custom regex - example: {id: \d+}
    $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

    # add start/end delimiters
    $route = '/^' . $route . '$/i';

    $this->routes[$route] = $params;
  }

  /**
   *
   * match URL to route in routing table,
   * setting parameters if match successful
   * 
   * @param string $url - Route URL
   *
   * @return boolean
   */
  
  public function match($url) {
    foreach ($this->routes as $route => $params) {
      if (preg_match($route, $url, $matches)) {
        foreach ($matches as $key => $match) {
          if (is_string($key)) {
            $params[$key] = $match;
          }
        }
        $this->params = $params;
        return true;
      }
    }
    return false;
  }

  /**
   *
   * get an array of all routes
   *
   * @return array
   */
  
  public function getRoutes() {
    return $this->routes;
  }

  /**
   *
   * get the currently matched params
   *
   * @return array
   */
  
  public function getParams() {
    return $this->params;
  }

}

<?php

/**
* Core Router
*
* PHP 7
* Written by John Lincoln 2017
*/

namespace Core;

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
   * Function getRoutes
   * get an array of all routes
   *
   * @return array
   */
  
  public function getRoutes() {
    return $this->routes;
  }

  /**
   *
   * Function getParams
   * get the currently matched params
   *
   * @return array
   */
  
  public function getParams() {
    return $this->params;
  }

  /**
  *
  * Function add
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
   * Function match
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
   * Function dispatch
   * dispatch the route --ADD MODE NOTES
   * 
   * @param string #url - Route URL
   *
   * @return void
   */

  public function dispatch($url) {
    #remove query string vars
    $url = $this->cleanseUrl($url); 

    if ($this->match($url)) {
      $controller = $this->params['controller'];
      $controller = $this->convertToStudlyCaps($controller);
      $controller = $this->getNamespace() . $controller;

      if (class_exists($controller)) {
        $controller_object = new $controller($this->params);

        $action = $this->params['action'];
        $action = $this->convertToCamelCase($action);

        if (preg_match('/action$/i', $action) == 0) {
          $controller_object->$action();
        } else {
          throw new \Exception("Method $action (in controller $controller) cannot be called directly.");
        }
      } else {
        throw new \Exception("Controller class $controller not found");
      }
    } else {
      throw new \Exception("No route matched", 404);
    }
  }

  /**
   *
   * Helper Functions
   * 
   */
  
  /**
   *
   * Function convertToStudlyCaps
   * convert a string to studley caps - e.g. StudlyCapsClass
   *
   * @param string $string - String to convert
   * @return string
   */
  
  protected function convertToStudlyCaps($string) {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
  }

  /**
   *
   * Funciton convertToCamelCase
   * convet a string to camel calse - e.g. camelCaseFunction
   *
   * @param string #string - String to convert
   * @return string
   */
  

  protected function convertToCamelCase($string) {
    return lcfirst($this->convertToStudlyCaps($string));
  }

  /**
   *
   * Function cleaseUrl
   * clease the URL of all query string variables
   * 
   * @param string $url - URL to cleanse
   * @return string
   */
  

  protected function cleanseUrl($url) {
    if ($url != '') {
      $parts = explode('&', $url, 2);


      if (strpos($parts[0], '=') === false) {
        $url = $parts[0];
      } else {
        $url = '';
      }
    }
    return $url;
  }

  /**
   *
   * Function getNamespace
   * get the namespace for a controller if passed as a route param
   *
   * @return string
   */

  protected function getNamespace() {
    $namespace = 'App\Controllers\\';

    if (array_key_exists('namespace', $this->params)) {
      $namespace .= $this->params['namespace'] . '\\';
    }
    return $namespace;
  }
}

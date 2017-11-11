<?php

/**
* Router
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
      $controller = "App\Controllers\\$controller";

      if (class_exists($controller)) {
        $controller_object = new $controller($this->params);

        $action = $this->params['action'];
        $action = $this->convertToCamelCase($action);

        if (is_callable([$controller_object, $action])) {
          $controller_object->$action();

        } else {
          echo "Method $action (in controller $controller) not found";
        }
      } else {
        echo "Controller class $controller not found";
      }
    } else {
      echo "No route matched";
    }
  }

/**

  TODO:
  - Add notes for these text conversion helper functions
  - Add notes to url cleansing function
  - Figure out where it makes sense for them to live

 */

  
  protected function convertToStudlyCaps($string) {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
  }

  protected function convertToCamelCase($string) {
    return lcfirst($this->convertToStudlyCaps($string));
  }

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

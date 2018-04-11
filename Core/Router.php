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
    * Routing table
    * @var array
    */
    protected $routes = [];

    /**
     * Parameters from matched route
     * @var array
     */
    protected $params = [];

    /**
     * Gets an array of all routes
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Gets the currently matched parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
    * Adds routes to the routing table
    *
    * @param string $route  - Route URL
    * @param array  $params - Parameters
    *
    * @return void
    */
    public function add($route, $params = [])
    {
        // convert route to regex
        $route = preg_replace('/\//', '\\/', $route);

        // convert route variables - example: {controller}/{action}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // add route variables with custom regex - example: {id: \d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // add start/end delimiters
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Matches URL to a route in the routing table. If successful, sets the parameters array.
     *
     * @param string $url - Route URL
     *
     * @return boolean
     */
    public function match($url)
    {
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
     * Dispatches the route
     *
     * @param string $url - Route URL
     *
     * @return void
     */
    public function dispatch($url)
    {
        // remove query string variables
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
     * Converts a string to studlycaps - e.g. StudlyCapsClass
     *
     * @param string $string - String to convert
     * @return string
     */
    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Converts a string to camelcase - e.g. camelCaseFunction
     *
     * @param string $string - String to convert
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Cleanses the URL of all query string variables
     *
     * @param string $url - URL to cleanse
     * @return string
     */
    protected function cleanseUrl($url)
    {
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
     * Gets the namespace for a controller if a controller is passed as a route variable.
     *
     * @return string
     */
    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }
}

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
     * Class constructor
     *
     * @param array $route_params - parameters from the matched route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     *
     * Function __call - PHP Magic method
     * Called when a bad method is called on a Core Controller object and allows for the implementation of action filters.
     *
     * @param string $name - method name
     * @param array $args - args passed to the method
     *
     * @example ALL actions must include the suffix Action - e.g. indexAction
     *
     * @return void
     */
    public function __call($name, $args)
    {
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
     * Executes before the controller action
     *
     * @return void
     */
    protected function before()
    {
        // blank slate
        // return false here to prevent the execution of the called action (auth)
    }

    /**
     * Executes after the controller action
     *
     * @return void
     */
    protected function after()
    {
        // blank slate
    }
}

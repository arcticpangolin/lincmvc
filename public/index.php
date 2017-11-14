<?php

/**
* LincMVC - A light PHP framework
*
* PHP 7
* @package LincMVC
* @author John Lincoln <jlincoln88@gmail.com>
*/

/**
 *
 * Register the Auto Loader
 *
 * Compuser provides a nice autoloader that we can leverage
 * for our framework.
 *
 */

require_once '../vendor/autoload.php';

/**
 *
 * Confirgure the Error Handler
 *
 * Lightweight error handling provided out of the box - to customize
 * your error handling, alter the class defied in the functions
 * below - i.e. Core\ErrorHandler
 *
 */

//error_reporting(E_ALL); //debug level error printing
set_error_handler('Core\ErrorHandler::errorHandler');
set_exception_handler('Core\ErrorHandler::exceptionHandler');

/**
 *
 * Instantiate a new router object
 *
 * Create a new router object to perform routing functions for the application.
 * .htaccess comes pre-configured to handle friendly URLs and maintain the query string.
 *
 */

$router = new Core\Router();

/**
 *
 * Application Routes
 *
 * Register the routes for your application here. These routes can
 * either be hard coded, or they can leverage variables wrapped in { }.
 * You can also add custom variables and define the regex in line - e.g. /{id:\d+}/
 * Some examples are provided below to get you started.
 * 
 */

$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('test/{controller}/{action}', ['namespace' => 'test']);

/**
 *
 * Dispatch the Route
 *
 * Effectively jumping into the application. You're off!!
 *
 */


$router->dispatch($_SERVER['QUERY_STRING']);
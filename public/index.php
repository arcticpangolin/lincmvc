<?php

/**
* Front controller
*
* PHP 7
* Written by John Lincoln 2017
*/

/**

  TODO:
  - clean up code
  - add comments to different pieces

 */


// require '../App/Controllers/HomeController.php';

// require '../Core/Router.php';

require_once '../vendor/autoload.php';


//error_reporting(E_ALL); //debug level error printing
set_error_handler('Core\ErrorHandler::errorHandler');
set_exception_handler('Core\ErrorHandler::exceptionHandler');


$router = new Core\Router();

$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('test/{controller}/{action}', ['namespace' => 'test']); //test route

$router->dispatch($_SERVER['QUERY_STRING']);




/**
 *
 * degub stuff
 *
 */

// echo '<pre>';
// echo htmlspecialchars(print_r($router->getRoutes(), true));
// echo '<pre>'; 

// $url = $_SERVER['QUERY_STRING'];
// if ($router->match($url)) {
//   echo '<pre>';
//   var_dump($router->getParams());
//   echo '<pre>';
// } else {
//   echo "No route found for URL '$url'";
// }
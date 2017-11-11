<?php

/**
* Front controller
*
* PHP 7
* Written by John Lincoln 2017
*/

//echo 'Request URL = "' . $_SERVER['QUERY_STRING'] .'"';


require '../Core/Router.php';

$router = new Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);
$router->add('{controller}/{action}');
$router->add('admin/{action}/{controller}');
$router->add('{controller}/{id:\d+}/{action}');

echo '<pre>';
echo htmlspecialchars(print_r($router->getRoutes(), true));
echo '<pre>'; 

$url = $_SERVER['QUERY_STRING'];
if ($router->match($url)) {
  echo '<pre>';
  var_dump($router->getParams());
  echo '<pre>';
} else {
  echo "No route found for URL '$url'";
}
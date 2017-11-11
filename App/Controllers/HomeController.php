<?php

/**

  TODO:
  - So many notes
  - Just make this actually a real thing not just  ahacky test.

 */
namespace App\Controllers;
use Core\Controller;

class HomeController extends Controller
{
  
  public function indexAction() {
    echo 'Hello from the home controller!! I am alive :)';
    echo '<p>Query string parameters: <pre>' . htmlspecialchars(print_r($_GET, true)) . '</pre></p>';
    echo '<p>Route parameters: <pre>' . htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
  }

  protected function before() {
    echo "first";
    # return false to not execute action
  }

  protected function after() {
    echo "last";
  }

}
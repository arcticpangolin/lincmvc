<?php

/**
 *
 * Controller HomeController
 * example controller displaying what ships with the framework
 *
 */


namespace App\Controllers;
use Core\Controller;
use Core\View;
use App\Models\SampleModel;

class HomeController extends Controller
{
  
  /**
   *
   * Function indexAction
   * renders the index template
   *
   * @return void
   */

  public function indexAction() {
    $samples = SampleModel::getAll();
    View::renderTemplate('Home/index.twig', ['samples' => $samples]);
  }

  /**
   *
   * Function before - action filter
   * called before the execution of the controller action
   * 
   * @return void
   */

  protected function before() {
    # code to run before action
    # return false to not execute action
  }

  /**
   *
   * Function after - action filter
   * called after the execution of the controller action
   * 
   * @return void
   */

  protected function after() {
    # code to run after action
  }

}
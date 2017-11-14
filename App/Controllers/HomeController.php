<?php

/**

  TODO:
  - So many notes
  - Just make this actually a real thing not just  ahacky test.

 */
namespace App\Controllers;
use Core\Controller;
use Core\View;
use App\Models\SampleModel;

class HomeController extends Controller
{
  

  protected function before() {
    # code to run before action
    # return false to not execute action
  }

  protected function after() {
    # code to run after action
  }

  public function indexAction() {
    $samples = SampleModel::getAll();
    View::renderTemplate('Home/index.twig', ['samples' => $samples]);
  }

}
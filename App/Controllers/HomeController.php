<?php

/**
 * The Home Controller
 *
 * @version PHP 7
 *
 * @example Controller
 * @package COREphp
 * @author John Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Models\SampleModel;

class HomeController extends Controller
{
    /**
     * Renders the index template
     *
     * @return void
     */
    public function indexAction()
    {
        $samples = SampleModel::getAll();
        View::renderTemplate('Home/index.twig', ['samples' => $samples]);
    }

    /**
     * Executes before the controller action
     *
     * @return void
     */
    protected function before()
    {
        // code to run before action
    }

    /**
     *
     * Executes after the controller action
     *
     * @return void
     */
    protected function after()
    {
        // code to run after action
    }
}

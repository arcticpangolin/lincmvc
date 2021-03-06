<?php

/**
* Core View
*
* @version PHP 7
*
* @package COREphp
* @author John Lincoln <jlincoln88@gmail.com>
* @copyright 2018 Arctic Pangolin
*/

namespace Core;

class View
{
    /**
     * Renders a view.
     *
     * @param string $view - the view file
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view";

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Renders a twig template.
     *
     * @param string $template - the template file
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);
        }

        echo $twig->render($template, $args);
    }
}

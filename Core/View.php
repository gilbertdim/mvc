<?php

namespace Core;
/**
 * View controller
 */

 class View
 {
     /**
      * Render a view file
      * @param string $view - the view file
      * @return void
      */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view"; // relative to Core directory
        
        if(is_readable($file))
        {
            require $file;
        }
        else
        {
            throw new \Exception("$file not found!");
        }
    }

    /**
     * Render a view template using Twig
     * @param string $template The template file
     * @param array $args Assiciative array of data to display in the view (optional)
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if($twig === null)
        {
            $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__).'/App/Views');
            $twig = new \Twig\Environment($loader);
        }

        echo $twig->render($template, $args);
    }
 }
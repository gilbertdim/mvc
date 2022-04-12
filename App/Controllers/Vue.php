<?php

namespace App\Controllers;

use Core\View;
use App\Config;
/**
 * Home Controller
 * Version 1
 */

class Vue extends \Core\Controller
{
    protected function before()
    {
        // echo "(before) ";
        // return false;
    }

    protected function after()
    {
        // echo " (after)";P
    }
    /**
     * Show the index php
     */
    public function indexAction()
    {
        View::renderTemplate('Vue/index.html');
    }
}
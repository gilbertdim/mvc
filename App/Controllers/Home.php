<?php

namespace App\Controllers;

use Core\View;
use App\Config;
/**
 * Home Controller
 * Version 1
 */

class Home extends \Core\Controller
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
        // echo "Hello from the index action in the HOME controller";
        // View::render('Home/index.php', [
        //     'name' => 'Gilbert',
        //     'colours' => [ 'red', 'blue', 'green' ],
        // ]);

        View::renderTemplate('Home/index.html', [
            'name' => 'Gilbert',
            'colours' => [ 'red', 'blue', 'green' ],
            'ini_config' => (new Config)->all(),
            'stat_config' => Config::get()
        ]);
    }
}
<?php

namespace App\Controllers\Admin;

/**
 * User admin controller
 */

class Users extends \Core\Controller
{
    /**
     * Before filter
     */
    protected function before()
    {
        // Make sure an admin user is logged in for example
        // return false;
    }

    public function indexAction()
    {
        echo 'User admin index';
    }
}
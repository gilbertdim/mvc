<?php

namespace Core;

use PDO;
use App\Config;

/**
 * Base model
 */

abstract class Model
{
    /**
     * Get the PDO database connection
     * @return mixed
     */
    protected static function getDB()
    {
        static $db = null;

        $host = Config::db_host();
        $db_name = Config::db_name();
        $user = Config::db_username();
        $password = Config::db_password();

        if($db === null)
        {
            $dns = "mysql:host=$host; dbname=$db_name; charset=utf8";
            $db = new PDO($dns, $user, $password);

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}
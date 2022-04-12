<?php

namespace App;

/**
 * Application Configuration
 */

class Config
{
    /**
     * Convert .env configuration into a static function
     * @param $func Function name set it to get() to listdown all configuration option
     * @param $args Key if the configuration file
     * @return string|property in configuration
     */
    public static function __callStatic($func, $args = [])
    {
        $config =  json_decode(file_get_contents('../.env'));

        if(property_exists($config, $func)) return $config->$func;
        if($func == 'get')
        {
            $config = (array) $config;
            if(count($args) > 0)
            {
                if(array_key_exists($args[0], $config))
                {
                    return $config[$args[0]];
                }
                else
                {
                    throw new \Exception("Config key '{$args[0]}' not found");
                }
            }

            return $config;
        }

        return null;
    }

    public function __construct()
    {
        $config =  json_decode(file_get_contents('../.env'));
        foreach($config as $key => $value)
        {
            $this->$key = $value;
        }
    }

    /**
     * List all configuration option
     * @return array Configuration options
     */
    public function all()
    {
        return $config =  json_decode(file_get_contents('../.env'), true);
    }
}
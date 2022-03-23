<?php

class App
{
    protected static $app = [];

    public static function get($key)
    {
        if(! array_key_exists($key, static::$app))
        {
            throw new Exception("No {$key} is in the registry.");

        }
        return static::$app[$key];
    }

    public static function set($key, $value)
    {
        static::$app[$key] = $value;
    }

    public static function load_config($fileName)
    {
        self::$app['config'] = require($fileName);
    }
}

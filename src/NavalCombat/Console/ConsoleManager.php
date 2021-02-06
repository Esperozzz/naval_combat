<?php

class ConsoleManager
{
    
    private static $init;
    
    public static function init()
    {
        if (empty(self::$init)) {
            self::init = new self();
        }
        return self::init;
    }
    
    private function __construct()
    {
        
    }
}

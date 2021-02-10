<?php

class ConsoleManager
{

    private static $init;
    private $arguments;
    
    private function __construct(){}
    
    public static function start(): self
    {
        if (empty(self::$init)) {
            self::$init = new self();
        }
        return self::$init;
    }
}

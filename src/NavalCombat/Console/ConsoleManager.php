<?php

class ConsoleManager
{
    private const INPUT_STRING_MAX_LENGTH = 10;
    
    private static $init;
    private $inputString;
    private $arguments;
    
    public static function start(): self
    {
        if (empty(self::$init)) {
            self::$init = new self();
        }
        return self::$init;
    }
    
    private function __construct(){}

    public function getInput(): void
    {
        $stdin = fopen('php://stdin', 'r');
        $this->inputString = stream_get_contents($stdin, self::INPUT_STRING_MAX_LENGTH);
    }

    public function returnInput(): array
    {

    }

    private function parseString(): array
    {

    }
}

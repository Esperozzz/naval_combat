<?php

class ConsoleManager
{
    private const INPUT_STRING_MAX_LENGTH = 3;
    private const MENU_OPTIONS_MAX_LENGTH = 1;
    
    private static $init;
    private $inputString;
    private $arguments;
    
    private function __construct(){}
    
    public static function start(): self
    {
        if (empty(self::$init)) {
            self::$init = new self();
        }
        return self::$init;
    }

    public function getInput(): void
    {
        $input = trim(readline());
        $this->inputString = substr($input, 0, self::INPUT_STRING_MAX_LENGTH);
    }
    
    /**
     * Проверяет, является ли ввод координатами
     */
    public function isCoordinate(string $inputStr): bool
    {
        return strlen($inputStr) > self::MENU_OPTIONS_MAX_LENGTH;
    }
    
    /**
     * Разбивает строку координат на составные части y и x
     */
    public function convertToCoordinate(string $coord): array
    {
        $y = substr($coord, 0, 1);
        
        return [
            'y' => (int) ord(strtoupper($y)),
            'x' => (int) substr($coord, 1, 2)
        ];
    }
    
    public function handler()
    {
         
    }

    public function returnInput()
    {
        return $this->inputString;
    }
    
    public function exit(): void
    {
        
    }

    private function inputPrepare(string $input): array
    {
        
    }
}

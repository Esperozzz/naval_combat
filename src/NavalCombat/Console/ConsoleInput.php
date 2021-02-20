<?php

class ConsoleInput
{
    private const INPUT_STRING_MAX_LENGTH = 7;
    private const PARAMETERS_MIN_LENGTH = 6;
    private const PARAMETERS_MAX_LENGTH = 7;
    private const COORDINATE_MIN_LENGTH = 2;
    private const COORDINATE_MAX_LENGTH = 3;
    private const MENU_OPTIONS_MAX_LENGTH = 1;


    private const PARAMETERS_SEPARATOR = ',';
    private const PARAMETERS_LIMIT = 3;
    
    private const BAD_COORDINATE =
    [
        'y' => 99,
        'x' => 99
    ];

    private const BAD_SHIP_PARAMETERS =
    [
        'y' => 99,
        'x' => 99,
        'size' => 5,
        'orientation' => 0
    ];
    
    private static $init = null;
    private $input;
    
    private function __construct(){}
    
    public static function init(): self
    {
        if (is_null(self::$init)) {
            self::$init = new self();
        }
        return self::$init;
    }

    /**
     * Считать строку ввода из консоли
     */
    public function read(): void
    {
        $input = trim(readline());
        $this->input = substr($input, 0, self::INPUT_STRING_MAX_LENGTH);
    }

    /**
     * Получить строку ввода, если отсутствует, пустую строку
     */
    public function toString(): string
    {
        return $this->input ?? '';
    }

    /**
     * Проверяет, является ли ввод опцией меню
     */
    public function isMenuOption(): bool
    {
        return $this->inputLength() === self::MENU_OPTIONS_MAX_LENGTH;
    }

    /**
     * Проверяет, является ли ввод координатами
     */
    public function isCoordinate(): bool
    {
        return ($this->inputLength() >= self::COORDINATE_MIN_LENGTH)
            && ($this->inputLength() <= self::COORDINATE_MAX_LENGTH);
    }

    /**
     * Проверят, является ли ввод параметрами
     */
    public function isParameters()
    {
        return ($this->inputLength() >= self::PARAMETERS_MIN_LENGTH)
            && ($this->inputLength() <= self::PARAMETERS_MAX_LENGTH);
    }

    /**
     * Возвращает строку опций меню
     */
    public function getMenuOption(): string
    {
        return $this->input ?? '';
    }

    /**
     * Разбивает строку на координаты y и x
     */
    public function getCoordinate(string $coordinates): array
    {
        return [
            'y' => (int) ord(strtoupper($coordinates[0])),
            'x' => (int) substr($coordinates, 1, 2)
        ];
    }
    
    /**
     * Разбивает строку на параметры y, x, размер, вертикаль/горизонталь (пример: j5,3,0)
     */
    public function getParameters(string $parameters): array
    {
        $paramList = explode(self::PARAMETERS_SEPARATOR, $parameters, self::PARAMETERS_LIMIT);
        if (count($paramList) === self::PARAMETERS_LIMIT) {

            $coord = $this->getCoordinate($paramList[0]);

            return [
                'y' => $coord['y'],
                'x' => $coord['x'],
                'size' => $this->correctSize($paramList[1]),
                'orientation' => $this->correctOrientation($paramList[2])
            ];
        }
        
        return self::BAD_SHIP_PARAMETERS;
    }
   
    /**
     *
     */
    private function correctSize($param): int
    {
        if (is_numeric($param) && ($param > 0 && $param <= 4)) {
            return (int) $param;
        }
        return 5;
    }
    
    /**
     *
     */
    private function correctOrientation($param): int
    {
        if (is_numeric($param) && ($param == 1)) {
            return $param;
        }
        return 0;
    }
    
    /**
     * Вычесляет длину строки ввода
     */
    private function inputLength(): int
    {
        return strlen($this->input);
    }
}

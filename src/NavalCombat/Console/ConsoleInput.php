<?php

class ConsoleInput
{
    private const INPUT_STRING_MAX_LENGTH = 3;
    private const MENU_OPTIONS_MAX_LENGTH = 1;

    private $input;

    /**
     * Считать строку ввода из консоли
     */
    public function read(): void
    {
        $input = trim(readline());
        $this->input = substr($input, 0, self::INPUT_STRING_MAX_LENGTH);
    }

    /**
     * Получить строку ввода
     */
    public function getString(): string
    {
        return $this->input ?? '';
    }

    public function isOption()
    {

    }

    /**
     * Проверяет, является ли ввод координатами
     */
    public function isCoordinate(): bool
    {
        return strlen($this->input) > self::MENU_OPTIONS_MAX_LENGTH;
    }

    /**
     * Разбивает строку координат на составные части y и x
     */
    public function convertToCoordinate(string $coordinates): array
    {
        return [
            'y' => (int) ord(strtoupper($coordinates[0])),
            'x' => (int) substr($coordinates, 1, 2)
        ];
    }
}

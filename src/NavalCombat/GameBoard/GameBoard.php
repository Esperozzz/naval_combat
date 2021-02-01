<?php

class GameBoard
{
    private const SHIP_CELL = 'X';
    
    private $board = [
        64 => [1 => 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        65 => [1 => 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        66 => [1 => 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        67 => [1 => 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        68 => [1 => 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        69 => [1 => 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        70 => [1 => 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        71 => [1 => 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        72 => [1 => 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        73 => [1 => 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        74 => [1 => 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        
    ];
    
    public function get(): array
    {
        return $this->board;
    }
    
    public function clear(): void
    {
        
    }
    
    /**
     * Добавляем на игровую доску корабль
     */
    public function addShip(Ship $ship): void
    {
        foreach ($ship->get() as $cell) {
            $this->setCell($cell['row'], $cell['col']);
        }
    }
    
    /**
     * Заполняем ячейку игрового поля
     */
    private function setCell($row, $col): void
    {
        if (isset($this->board[$row][$col])) {
            $this->board[$row][$col] = self::SHIP_CELL;
        }
    }
    
}

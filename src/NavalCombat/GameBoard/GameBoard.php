<?php

class GameBoard
{
    private const BATTLESHIP_LIMIT = 1;
    private const CRUISER_LIMIT = 2;
    private const DESTROYER_LIMIT = 3;
    private const BOAT_LIMIT = 4;
    
    private const Y_LOW_BOUND = 65;
    private const Y_UP_BOUND = 74;
    private const X_LOW_BOUND = 1;
    private const X_UP_BOUND = 10;
    
    private const EMPTY_CELL = '.';
    private const SHIP_CELL = 'H';
    private const DESTROY_CELL = 'X';
    private const MISS_CELL = 'o';
    
    private $ships = [];
    private $missed = [];
    private $damaged = [];
    
    public function __construct()
    {
        $this->create();
        
        $this->ships['boats'] = [];
        $this->ships['destroyers'] = [];
        $this->ships['cruisers'] = [];
        $this->ships['battleships'] = [];
    }
    
    /**
     * Получить игровую доску
     */
    public function get(): array
    {
        return $this->board;
    }
    
    /**
     * Очистить игровую доску
     */
    public function clear(): void
    {
        $this->board = [];
        $this->create();
    }
    
    public function getShips()
    {
        return $this->ships;
    }
    
    public function addShip(Ship $ship)
    {
        switch ($ship->getSize()) {
            case (1): 
                if ($this->shipLimitedNotExceeded($this->ships['boats'], self::BOAT_LIMIT)) {
                    $this->ships['boats'][] = $ship;
                }
                break;
            case (2):
                if ($this->shipLimitedNotExceeded($this->ships['destroyers'], self::DESTROYER_LIMIT)) {
                    $this->ships['destroyers'][] = $ship;
                }
                break;
            case (3): 
                if ($this->shipLimitedNotExceeded($this->ships['cruisers'], self::CRUISER_LIMIT)) {
                    $this->ships['cruisers'][] = $ship;
                }
                break;
            case (4): 
                if ($this->shipLimitedNotExceeded($this->ships['battleships'], self::BATTLESHIP_LIMIT)) {
                    $this->ships['battleships'][] = $ship;
                }
                break;
        }
    }
    
    private function shipLimitedNotExceeded(array $shipArr, int $maxLimit): bool
    {
        if (count($shipArr) < $maxLimit) {
            return true;
        }
        return false;
    }
    
    /**
     * Добавляем на игровую доску корабль
     */
    public function addShipTest(Ship $ship): void
    {
        foreach ($ship->get() as $cell) {
            $this->setCell($cell['row'], $cell['col']);
        }
    }
    
    /**
     * Обновляет состояние доски, добавляя корабли, промахи и попадания из соответствующих сврйств
     */
    public function update()
    {
        $this->updateShips();
    }
    
    /**
     * Обновляет информацию о кораблях на поле
     */
    private function updateShips(): void
    {
        foreach ($this->ships as $ships) {
            foreach ($ships as $ship) {
                foreach ($ship->get() as $decks) {
                    $this->setCell($decks['row'], $decks['col']);
                }
            }
        }
    }
    
    public function addDamageCell($y, $x)
    {

    }
    
    public function addMissCell($y, $x)
    {
        //Проверяем ячейку на существование ячейки
            //Если существует, добаляем
    }
    
    /**
     * Создает пустое игровое поле
     */
    private function create(): void
    {
        for ($yKey = self::Y_LOW_BOUND - 1; $yKey <= self::Y_UP_BOUND; $yKey++) {
            $this->board[$yKey] = array_fill(1, self::X_UP_BOUND, self::EMPTY_CELL);
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

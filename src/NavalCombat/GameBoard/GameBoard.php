<?php

class GameBoard
{
    private const BATTLESHIP_LIMIT = 1;
    private const CRUISER_LIMIT = 2;
    private const DESTROYER_LIMIT = 3;
    private const BOAT_LIMIT = 4;
    
    private const Y_LOW_BOUND = 65;
    private const X_LOW_BOUND = 1;
    private const Y_UP_BOUND = 74;
    private const X_UP_BOUND = 10;
    
    private const EMPTY_CELL = '.';
    private const SHIP_CELL = 'H';
    private const DESTROY_CELL = 'X';
    private const MISS_CELL = 'o';
    
    private $board = [];
    
    private $ships = [];
    private $shadows = [];
    private $miss = [];
    private $damage = [];
    
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
     * Получить размеры игровой доски
     */
    public function getOptions(): GameBoardOptions
    {
        return new GameBoardOptions(
            self::Y_LOW_BOUND,
            self::X_LOW_BOUND,
            self::Y_UP_BOUND,
            self::X_UP_BOUND
        );
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
    
    public function addFire($y, $x): bool
    {
        //Временно исправит работу
        $this->update();
        
        switch ($this->board[$y][$x]) {
            case (self::SHIP_CELL):
                $this->addDamage($y, $x);
                return true;
            case (self::EMPTY_CELL):
                $this->addMiss($y, $x);
                return true;
            default:
                return false;
                
        }
    }

    /**
     * Сравнивает тень корабля с списком теней добавленным на доску
     */
    private function compareShipShadows(Ship $ship): bool
    {

        return true;
    }

    /**
     * Добавляет тень корабля в
     */
    private function addShadow(): void
    {

    }

    private function addDamage($y, $x)
    {
        $this->damage[] = ['y' => $y, 'x' => $x];
    }
    
    private function addMiss($y, $x)
    {
        $this->miss[] = ['y' => $y, 'x' => $x];
    }
    
    private function shipLimitedNotExceeded(array $shipArr, int $maxLimit): bool
    {
        return count($shipArr) < $maxLimit;
    }
    
    /**
     * Обновляет состояние доски, добавляя корабли, промахи и попадания из соответствующих сврйств
     */
    public function update()
    {
        $this->updateShips();
        $this->updateMiss();
        $this->updateDamage();
    }
    
    /**
     * Обновляет информацию о кораблях на поле
     */
    private function updateShips(): void
    {
        foreach ($this->ships as $ships) {
            foreach ($ships as $ship) {
                foreach ($ship->get() as $decks) {
                    $this->setCell($decks['y'], $decks['x'], self::SHIP_CELL);
                }
            }
        }
    }
    
    private function updateMiss()
    {
        foreach ($this->miss as $missCell) {
            $this->setCell($missCell['y'], $missCell['x'], self::MISS_CELL);
        }
    }
    
    private function updateDamage()
    {
        foreach ($this->damage as $damageCell) {
            $this->setCell($damageCell['y'], $damageCell['x'], self::DESTROY_CELL);
        }
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
    private function setCell(int $y, int $x, $state): void
    {
        if (isset($this->board[$y][$x])) {
            $this->board[$y][$x] = $state;
        }
    }
    
}

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

    private const SHADOW_CELL = '*';

    private const EMPTY_CELL = '.';
    private const SHIP_CELL = 'H';
    private const DESTROY_CELL = 'X';
    private const MISS_CELL = 'o';
    
    private $boardMap;
    private $shadowMap;
    
    private $shipsList;
    
    public function __construct()
    {
        $this->boardMap = $this->create();
        $this->shadowMap = $this->create();
        
        $this->shipsList['boats'] = [];
        $this->shipsList['destroyers'] = [];
        $this->shipsList['cruisers'] = [];
        $this->shipsList['battleships'] = [];
    }
    
    /**
     * Получить игровую доску
     */
    public function get(): array
    {
        return $this->boardMap;
    }

    /**
     * Получить доску теней игрового поля
     */
    public function getShadow(): array
    {
        return $this->shadowMap;
    }

    /**
     * Получить опции игровой доски
     */
    public function getSizeOptions(): GameBoardSizeOptions
    {
        return new GameBoardSizeOptions(
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
        $this->boardMap = [];
        $this->create();
    }

    /**
     * Обновляет информацию о кораблях на поле
     */
    public function updateShipsPosition(): void
    {
        foreach ($this->shipsList as $ships) {
            foreach ($ships as $ship) {
                foreach ($ship->get() as $decks) {
                    $this->setCell($decks['y'], $decks['x'], self::SHIP_CELL);
                }
            }
        }
    }

    public function addShip(Ship $ship): bool
    {
        if (!$this->canIAddAShip($ship)) {
            return false;
        }

        $this->addShadow($ship);

        switch ($ship->getSize()) {
            case (1): 
                if ($this->shipLimitedNotExceeded($this->shipsList['boats'], self::BOAT_LIMIT)) {
                    $this->shipsList['boats'][] = $ship;
                }
                break;
            case (2):
                if ($this->shipLimitedNotExceeded($this->shipsList['destroyers'], self::DESTROYER_LIMIT)) {
                    $this->shipsList['destroyers'][] = $ship;
                }
                break;
            case (3): 
                if ($this->shipLimitedNotExceeded($this->shipsList['cruisers'], self::CRUISER_LIMIT)) {
                    $this->shipsList['cruisers'][] = $ship;
                }
                break;
            case (4): 
                if ($this->shipLimitedNotExceeded($this->shipsList['battleships'], self::BATTLESHIP_LIMIT)) {
                    $this->shipsList['battleships'][] = $ship;
                }
                break;
        }
        
        return true;
    }
    
    public function addFire($y, $x): bool
    {
        switch ($this->boardMap[$y][$x]) {
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
     * Добавляет тень корабля на доску теней
     */
    private function addShadow(Ship $ship): void
    {
        foreach ($ship->getShadow() as $shadowCell) {
            $this->setShadowCell($shadowCell['y'], $shadowCell['x']);
        }
    }

    /**
     * Сравнивает тень корабля с списком теней добавленныx на доску
     */
    private function canIAddAShip(Ship $ship): bool
    {
        foreach ($ship->get() as $shipDeck) {
            if ($this->shadowCellIsBusy($shipDeck['y'], $shipDeck['x'])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Проверяет заполнин ли предел типа корабля
     */
    private function shipLimitedNotExceeded(array $shipArr, int $maxLimit): bool
    {
        return count($shipArr) < $maxLimit;
    }

    /**
     * Создает пустое игровое поле
     */
    private function create(): array
    {
        $board = [];
        for ($yKey = self::Y_LOW_BOUND - 1; $yKey <= self::Y_UP_BOUND; $yKey++) {
            $board[$yKey] = array_fill(1, self::X_UP_BOUND, self::EMPTY_CELL);
        }
        
        return $board;
    }

    /**
     * Добавить ячейку урона на поле
     */
    private function addDamage(int $y, int $x): void
    {
        $this->setCell($y, $x, self::DESTROY_CELL);
    }

    /**
     * Добавить ячейку промаха на поле
     */
    private function addMiss(int $y, int $x): void
    {
        $this->setCell($y, $x, self::MISS_CELL);
    }

    /**
     * Заполняем ячейку игрового поля
     */
    private function setCell(int $y, int $x, $setValue): void
    {
        if (isset($this->boardMap[$y][$x])) {
            $this->boardMap[$y][$x] = $setValue;
        }
    }

    /**
     * Заполняем ячейку тени
     */
    private function setShadowCell(int $y, int $x): void
    {
        if (isset($this->shadowMap[$y][$x])) {
            $this->shadowMap[$y][$x] = self::SHADOW_CELL;
        }
    }

    /**
     * Проверяет, установлена ли ячейка тени
     */
    private function shadowCellIsBusy(int $y, int $x): bool
    {
        return $this->getCell($y, $x, $this->shadowMap) === self::SHADOW_CELL;
    }

    /**
     * Получает ячейку указанного поля
     */
    private function getCell(int $y, int $x, array $board)
    {
        return $board[$y][$x];
    }
}

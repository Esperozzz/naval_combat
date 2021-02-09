<?php

class GameBoard
{
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
    private $shipStorage;
    
    public function __construct()
    {
        $this->boardMap = $this->create();
        $this->shadowMap = $this->create();
        
        $this->shipStorage = new ShipStorage();
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
     * Очищает доску теней, для освобождения памяти
     */
    public function clearShadow(): void
    {
        $this->shadowMap = [];
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
    public function updateShipsPosition(ShipStorage $storage): void
    {
        foreach ($storage->getShips() as $ship) {
            foreach ($ship->get() as $decks) {
                $this->setCell($decks['y'], $decks['x'], self::SHIP_CELL);
            }
        }
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
    public function addShadow(Ship $ship): void
    {
        foreach ($ship->getShadow() as $shadowCell) {
            $this->setShadowCell($shadowCell['y'], $shadowCell['x']);
        }
    }

    /**
     * Сравнивает тень корабля с списком теней добавленныx на доску
     */
    public function canIAddAShip(Ship $ship): bool
    {
        foreach ($ship->get() as $shipDeck) {
            if ($this->shadowCellIsBusy($shipDeck['y'], $shipDeck['x'])) {
                return false;
            }
        }
        return true;
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

    private function addError(string $message): void
    {
        $this->errors[] = $message;
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
        return $this->getShadowCell($y, $x) === self::SHADOW_CELL;
    }

    /**
     * Получает ячейку указанного поля
     */
    private function getShadowCell(int $y, int $x)
    {
        return $this->shadowMap[$y][$x];
    }
    
    /**
     *
     */
    private function isSetCell(int $y, int $x): bool
    {
        return isset($this->boardMap[$y][$x]);
    }
}

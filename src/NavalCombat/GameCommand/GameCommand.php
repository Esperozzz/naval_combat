<?php

/**
 * Класс отвечает за действия отдельного игрока
 */
class GameCommand
{
    private const STATE_DEFAULT = 0;
    private const STATE_MISFIRE = 1;
    private const STATE_HIT_ON_THE_SHIP = 2;
    private const STATE_SHIP_DESTROYED = 3;
    private const STATE_ALL_SHIPS_DESTROYED = 4;
    private const STATE_SHIP_LIMIT_REACHED = 5;
    private const STATE_SHIP_COORDINATES_NOT_CORRECT = 6;
    private const STATE_SHIP_GOES_OUTSIDE_THE_FIELD = 7;
    private const STATE_COORDINATES_ALREADY_SET = 8;
    private const STATE_ALL_SHIPS_SET = 9;
    
    private $board;
    private $dockyard;
    private $ships;
    private $damageManager;
    
    private $state;
    private $messages;

    /**
     * Класс является оболочкой для команд относящихся к игровой механтке
     */
    public function __construct()
    {
        $this->state = self::STATE_DEFAULT;
        
        $this->board = new GameBoard();
        $options = $this->board->getSizeOptions();
        $this->dockyard = new Dockyard($options);
        $this->ships = new ShipStorage();

        $this->damageManager = new ShipDamageManager($this->ships);
        $this->messages = new GameMessage();
    }

    /**
     * Создаем корабль и добавляем в хранилище
     */
    public function addShipOnBoard(int $y, int $x, int $size, int $orientation): bool
    {
        $newShip = $this->dockyard->constructShip($y, $x, $size, $orientation);
        
        if ($this->shipIsComplete($newShip)) {
            $this->board->addShipShadow($newShip);
            return true;
        }
        return false;
    }

    /**
     * Обновляет информацию о кораблях на игровом поле
     */
    public function updateBoardInfo(): void
    {
        $this->board->installShipsOnBoard($this->ships);
    }

    /**
     * Проверяет, все ли корабли установлены на игровое поле
     */
    public function allShipSet(): bool
    {
        if ($this->ships->isFull()) {
            $this->state = self::STATE_ALL_SHIPS_SET;
            return true;
        }
        return false;
    }

    /**
     * Подготавливает карту урона кораблей
     */
    public function prepareShipDamageManager(): void
    {
        $this->damageManager->setDamageMap();
    }

    /**
     * Пытается добавить выстрел на игровую доску
     */
    public function fire(int $y, int $x): bool
    {
        $fireAdd = false;
        
        switch ($this->board->addFire($y, $x)) {
            case (0):
                //Промах
                $this->state = self::STATE_MISFIRE;
                $this->messages->add('You missed!');
                $fireAdd = true;
                break;
            case (1):
                //Попадание
                $this->state = self::STATE_HIT_ON_THE_SHIP;
                $this->messages->add('Ship is damaged!');
                $fireAdd = true;
                break;
            default:
                //Попадание в уже занятую ячейку
                $this->state = self::STATE_COORDINATES_ALREADY_SET;
                $this->messages->add('Such coordinates have already been. Repeat the move.');
                break;
        }

        //Проверяем, уничтожен ли корабль росле выстрела
        if ($this->damageManager->shipIsDestroyed($y, $x)) {
            $this->state = self::STATE_SHIP_DESTROYED;
            $this->messages->add('Ship is destroyed!');
        }
        
        return $fireAdd;
    }

    /**
     * Проверяет, уничтожен ли корабль
     */
    public function shipsIsDestroyed(): bool
    {
        if ($this->damageManager->allShipsDestroyed()) {
            $this->state = self::STATE_ALL_SHIPS_DESTROYED;
            $this->messages->add('ALL DESRTOYED!!!!');
            return true;
        }
        return false;
    }

    /**
     *
     */
    public function getBoard(): GameBoard
    {
        return $this->board;
    }
    
    /**
     *
     */
    public function getMessages(): GameMessage
    {
        return $this->messages;
    }

    /**
     * Возвращает статус выполнения команд
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * Приводит статус выполнения команд к значению по умолчанию
     */
    public function resetState(): void
    {
        $this->state = self::STATE_DEFAULT;
    }

    /**
     * Пытается создать корабль по полученным координатам
     */
    private function shipParamsIsCorrect(Ship $ship): bool
    {
        if ($ship instanceof Wreck) {
            $this->state = self::STATE_SHIP_GOES_OUTSIDE_THE_FIELD;
            $this->messages->add('Ship goes beyond the border of the playing field');
            return false;
        }
        return true;
    }

    /**
     * Провеояет корректность указанных координат корабля
     */
    private function shipShadowIsCorrect(Ship $ship): bool
    {
        if (!$this->board->canIAddAShip($ship)) {
            $this->state = self::STATE_SHIP_COORDINATES_NOT_CORRECT;
            $this->messages->add('The ships coordinates are not correct. A ship must not cross the boundaries of another ship.');
            return false;
        }
        return true;
    }
    
    /**
     * Пытается добавить корабль в хранилище кораблей
     */
    private function shipIsSave(Ship $ship): bool
    {
        if (!$this->ships->add($ship)) {
            $this->state = self::STATE_SHIP_LIMIT_REACHED;
            $this->messages->add('The limit of ships of this type is exceeded');
            return false;
        }
        return true;
    }

    /**
     * Проверяет, все ли данные для создания корабля готовы
     */
    private function shipIsComplete(Ship $ship): bool
    {
        if ($this->shipParamsIsCorrect($ship) && $this->shipShadowIsCorrect($ship) && $this->shipIsSave($ship)) {
            return true;
        }
        return false;
    }
}

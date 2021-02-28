<?php

class GameCommand
{
    private $board;
    private $dockyard;
    private $ships;
    private $damageManager;
    
    private $messages;

    /**
     *
     */
    public function __construct()
    {
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
        //Создаем корабль по переданным параметрам
        $newShip = $this->dockyard->constructShip($y, $x, $size, $orientation);
        if ($newShip instanceof Wreck) {
            $this->messages->add('Ship goes beyond the border of the playing field');
            return false;
        }

        //Проверяем, не пересекается ли корабль с уже установленными тенями
        if (!$this->board->canIAddAShip($newShip)) {
            $this->messages->add('The ships coordinates are not correct. A ship must not cross the boundaries of another ship.');
            return false;
        }
        
        //Пытаемся добавить корабль в хранилище кораблей
        if (!$this->ships->add($newShip)) {
            $this->messages->add('The limit of ships of this type is exceeded');
            return false;
        }
        
        $this->board->addShipShadow($newShip);
        return true;
    }

    /**
     *
     */
    public function updateBoardInfo(): void
    {
        $this->board->installShipsOnBoard($this->ships);
    }

    /**
     *
     */
    public function allShipSet(): bool
    {
        return $this->ships->isFull();
    }

    /**
     *
     */
    public function prepareShipDamageManager(): void
    {
        $this->damageManager->setDamageMap();
    }

    /**
     *
     */
    public function fire(int $y, int $x): bool
    {
        $status = false;
        
        switch ($this->board->addFire($y, $x)) {
            case (0):
                $this->messages->add('You missed!');
                $status = true;
                break;
            case (1):
                $this->messages->add('Ship is damaged!');
                $status = true;
                break;
            default:
                $this->messages->add('Such coordinates have already been. Repeat the move.');
                break;
        }

        if ($this->damageManager->shipIsDestroyed($y, $x)) {
            $this->messages->add('Ship is destroyed!');
        }
        
        return $status;
    }

    public function shipsDestroyed(): bool
    {
        if ($this->damageManager->allShipsDestroyed()) {
            $this->messages->add('ALL DESRTOYED!!!!');
            return true;
        }
        return false;
    }

    public function getBoard(): GameBoard
    {
        return $this->board;
    }
    
    public function getMessages(): GameMessage
    {
        return $this->messages;
    }

    /**
     * Проверяет, все ли данные для создания корабля готовы
     */
    private function shipIsComplete(): bool
    {

    }
}

<?php

class GameCommand
{
    private $board;
    private $dockyard;
    private $ships;
    private $damageManager;
    
    private $messages;
    
    public function __construct()
    {
        $this->board = new GameBoard();
        $options = $this->board->getSizeOptions();
        $this->dockyard = new Dockyard($options);
        $this->ships = new ShipStorage();

        $this->damageManager = new ShipDamageManager($this->ships);
        $this->messages = new GameMessage();

    }
    
    //Создаем корабль и добавляем в хранилище
    public function addShipOnBoard($y, $x, $size, $orientation): bool
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
    
    public function updateBoardInfo()
    {
        $this->board->installShipsOnBoard($this->ships);
    }
    
    public function allShipSet(): bool
    {
        return $this->ships->isFull();
    }

    public function prepareShipDamageManager()
    {
        $this->damageManager->setDamageMap();
    }

    public function fire($y, $x)
    {
        $fire = $this->board->addFire($y, $x);

        $this->damageManager->setDamageMap();

        $this->clearErrors();

        if ($this->damageManager->shipIsDestroyed($y, $x)) {
            $this->addError('Ship is destroyed!');
        }
        foreach ($this->getErrors() as $error) {
            echo $error . PHP_EOL;
            echo PHP_EOL;
        }
        
        if ($this->damageManager->allShipsDestroyed()) {
            echo 'ALL DESRTOYED!!!!';
        }
        
        //$fire = $this->playerBoard->addFire(67, 1);
        /*
        $message = '';
        switch ($fire) {
            case (0):
                $message = 'Miss';
                break;
            case (1):
                $message = 'Hit';
                break;
            default:
                $message = 'Enter a different cell';
                break;
        }
        */
    }

    public function getBoard(): GameBoard
    {
        return $this->board;
    }
    
    public function getMessages(): GameMessage
    {
        return $this->messages;
    }
}

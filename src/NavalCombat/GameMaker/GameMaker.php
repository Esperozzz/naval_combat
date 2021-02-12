<?php

class GameMaker
{
    private $playerBoard;
    private $computerBoard;
    
    private $playerDockyard;
    private $computerDockyard;
    
    private $playerShips;
    private $computerShips;
    
    private $damageManager;
    
    private $errors = [];
    
    public function __construct()
    {
        $this->playerBoard = new GameBoard();
        $playerOptions = $this->playerBoard->getSizeOptions();
        $this->playerDockyard = new Dockyard($playerOptions);
        $this->playerShips = new ShipStorage();
        
        $this->computerBoard = new GameBoard();
        $computerOptions = $this->computerBoard->getSizeOptions();
        $this->computerDockyard = new Dockyard($computerOptions);
        $this->computerShips = new ShipStorage();
        
        $this->damageManager = new ShipDamageManager($this->playerShips);
        
    }
    
    //Создаем корабль и добавляем в хранилище
    public function playerShipAdd($y, $x, $size, $orientation): bool
    {
        //Создаем корабль по переданным параметрам
        $newShip = $this->playerDockyard->constructShip($y, $x, $size, $orientation);
        if (is_null($newShip)) {
            $this->addError('Unspecified ship data');
            return false;
        }
        
        //Проверить, выходит ли корабль за пределы поля
        
        //Проверяем, не пересекается ли корабль с уже установленными тенями
        if (!$this->playerBoard->canIAddAShip($newShip)) {
            $this->addError('The ships coordinates are not correct. A ship must not cross the boundaries of another ship.');
            return false;
        }
        
        //Пытаемся добавить корабль в хранилище кораблей
        if (!$this->playerShips->add($newShip)) {
            $this->addError('The limit of ships of this type is exceeded');
            return false;
        }
        
        $this->playerBoard->addShipShadow($newShip);
        return true;
    }
    
    
    public function allShipSet()
    {
        $this->playerBoard->installShipsOnBoard($this->playerShips);
        foreach ($this->getErrors() as $error) {
            echo $error . PHP_EOL;
            echo PHP_EOL;
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

    public function fire($y, $x)
    {
        $fire = $this->playerBoard->addFire($y, $x);
        
        if ($this->damageManager->shipIsDestroyed($y, $x)) {
            echo 'DESTR!';
            $this->addError('Ship is destroyed!');
        }
        foreach ($this->getErrors() as $error) {
            echo $error . PHP_EOL;
            echo PHP_EOL;
        }
    }

    public function getPlayerBoard(): GameBoard
    {
        return $this->playerBoard;
    }
    
    public function getComputerBoard(): GameBoard
    {
        return $this->computerBoard;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function addError($message): void
    {
        $this->errors[] = $message;
    }
}

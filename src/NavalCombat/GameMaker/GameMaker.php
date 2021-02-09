<?php

class GameMaker
{
    private $playerBoard;
    private $computerBoard;
    
    private $playerDockyard;
    private $computerDockyard;
    
    private $playerShips;
    private $computerShips;
    
    private $errors = [];
    
    public function __construct()
    {
        $playerOptions = null;
        $computerOption = null;
        
        $this->playerBoard = new GameBoard();
        $playerOptions = $this->playerBoard->getSizeOptions();
        $this->playerDockyard = new Dockyard($playerOptions);
        $this->playerShips = new ShipStorage();
        
        $this->computerBoard = new GameBoard();
        $computerOptions = $this->computerBoard->getSizeOptions();
        $this->computerDockyard = new Dockyard($computerOptions);
        $this->computerShips = new ShipStorage();
        
    }
    
    //Создаем корабль и добавляем в хранилище
    public function playerShipAdd($y, $x, $size, $orientation): bool
    {
        //Создаем корабль по переданным параметрам
        $newShip = $this->playerDockyard->constructShip($y, $x, $size, $orientation);
        if (is_null($newShip)) {
            $this->errors[] = 'Unspecified ship data';
            return false;
        }
        
        //Проверить, выходит ли корабль за пределы поля
        
        //Проверяем, не пересекается ли корабль с уже установленными тенями
        if (!$this->playerBoard->canIAddAShip($newShip)) {
            $this->errors[] = 'The ships coordinates are not correct. A ship must not cross the boundaries of another ship.';
            return false;
        }
        
        //Пытаемся добавить корабль в хранилище кораблей
        if (!$this->playerShips->add($newShip)) {
            $this->errors[] = 'The limit of ships of this type is exceeded';
            return false;
        }
        
        $this->playerBoard->addShadow($newShip);
        return true;
    }
    
    
    public function allShipSet()
    {
        $this->playerBoard->updateShipsPosition($this->playerShips);
        foreach ($this->getErrors() as $error) {
            echo $error . PHP_EOL;
            echo PHP_EOL;
        }
        
    }
    
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    public function getPlayerBoard(): GameBoard
    {
        return $this->playerBoard;
    }
    
    public function getComputerBoard(): GameBoard
    {
        return $this->computerBoard;
    }
}

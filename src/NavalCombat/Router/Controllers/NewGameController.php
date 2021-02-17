<?php

class NewGameController extends Controller
{
    private $playerBoard;
    private $playerDockyard;
    private $playerShips;

    public function __construct()
    {
        $this->playerBoard = new GameBoard();
        $playerOptions = $this->playerBoard->getSizeOptions();
        $this->playerDockyard = new Dockyard($playerOptions);
        $this->playerShips = new ShipStorage();
    }

    public function getCommand(): string
    {
        return '1';
    }

    public function getName(): string
    {
        return 'New game';
    }

    public function view(View $view): void
    {
        $view->boardAndShadow($this->playerBoard);
        
        echo 'Enter new ship coordinate: ';
    }

    public function execute(): void
    {
        $input = ConsoleInput::init()->toString();
        if (ConsoleInput::init()->isCoordinate()) {
            
        $coord = ConsoleInput::init()->convertToCoordinate($input);
        
        //Создаем корабль по переданным параметрам
        $newShip = $this->playerDockyard->constructShip(
            $coord['y'],
            $coord['x'],
            1,
            0);
        
        if (is_null($newShip)) {
            //$this->addError('Unspecified ship data');
            //return false;
        }
        
        //Проверить, выходит ли корабль за пределы поля
        
        //Проверяем, не пересекается ли корабль с уже установленными тенями
        if (!$this->playerBoard->canIAddAShip($newShip)) {
            //$this->addError('The ships coordinates are not correct. A ship must not cross the boundaries of another ship.');
            //return false;
        }
        
        //Пытаемся добавить корабль в хранилище кораблей
        $this->playerShips->add($newShip);
            //$this->addError('The limit of ships of this type is exceeded');
            //return false;
        //}
        
        $this->playerBoard->addShipShadow($newShip);
        //return true;
        
        $this->playerBoard->installShipsOnBoard($this->playerShips);
        }
        
    }
}

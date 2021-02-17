<?php

class NewGameController extends Controller
{
    private $playerCommand;

    public function __construct()
    {
        $this->playerCommand = new GameCommand();
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
        $view->boardAndShadow($this->playerCommand->getBoard());
        
        echo 'Enter new ship coordinate: ';
    }

    public function execute(): void
    {
        $input = ConsoleInput::init()->toString();
        if (ConsoleInput::init()->isCoordinate()) {

            $coord = ConsoleInput::init()->convertToCoordinate($input);

            //Создаем корабль по переданным параметрам
            $newShip = $this->playerCommand->addShipOnBoard(
                $coord['y'],
                $coord['x'],
                1,
                0);
        }
        
    }
}

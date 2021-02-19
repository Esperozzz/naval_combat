<?php

class NewGameController extends Controller
{
    private $playerCommand;

    public function __construct()
    {
        $this->playerCommand = new GameCommand();
    }

    public function prepareData()
    {

    }

    public function view(View $view): void
    {
        $messages = $this->playerCommand->getMessages()->getAll();
        
        foreach ($messages as $message) {
            echo $message . PHP_EOL;
        }
        echo PHP_EOL;
        
        $view->boardAndShadow($this->playerCommand->getBoard());
        
        echo 'Enter new ship coordinate: ';
        
        $this->playerCommand->getMessages()->clear();
    }

    public function execute(): void
    {
        $input = ConsoleInput::init()->toString();
        
        //Устанавливаем уорабли на поле
        if (!$this->playerCommand->allShipSet()) {
        
            if (ConsoleInput::init()->isCoordinate()) {
                $coord = ConsoleInput::init()->convertToParameters($input);
                
                //Создаем корабль по переданным параметрам
                $newShip = $this->playerCommand->addShipOnBoard($coord['y'], $coord['x'], $coord['size'], $coord['orientation']);
            }
            
            //Обновление информации
            $this->playerCommand->updateBoardInfo();
        }
        
        $this->playerCommand->prepareShipDamageManager();
        
        
        
    }
    
    public function getCommand(): string
    {
        return '1';
    }

    public function getName(): string
    {
        return 'New game';
    }
}

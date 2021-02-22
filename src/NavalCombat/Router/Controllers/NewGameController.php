<?php

class NewGameController extends Controller
{
    private $bot;
    private $playerCommand;
    private $computerCommand;
    private $playerShipsSetOnBoard = false;
    private $computerShipsSetOnBoard = false;
    
    private $testShips;

    public function __construct()
    {
        $this->bot = new GameBot();
        $this->playerCommand = new GameCommand();
        $this->computerCommand = new GameCommand();
        
        $ships = [
            ['y' => 70, 'x' => 5, 'size' => 4, 'orient' => 1],
            ['y' => 65, 'x' => 2, 'size' => 1, 'orient' => 0],
            ['y' => 65, 'x' => 7, 'size' => 3, 'orient' => 1],
            ['y' => 67, 'x' => 1, 'size' => 1, 'orient' => 1],
            ['y' => 68, 'x' => 3, 'size' => 1, 'orient' => 1],
            ['y' => 69, 'x' => 1, 'size' => 1, 'orient' => 1],
            ['y' => 70, 'x' => 8, 'size' => 2, 'orient' => 0],
            ['y' => 74, 'x' => 1, 'size' => 2, 'orient' => 0],
            ['y' => 71, 'x' => 1, 'size' => 3, 'orient' => 0],
            ['y' => 74, 'x' => 8, 'size' => 2, 'orient' => 0],
        ];
        
        $this->testShips = $ships;

    }

    public function saveData(): void
    {

    }

    public function view(View $view): void
    {
        $messages = $this->playerCommand->getMessages()->getAll();
        
        foreach ($messages as $message) {
            echo $message . PHP_EOL;
        }
        echo PHP_EOL;

        //Вывод игровых полей
        if ($this->playerShipsSetOnBoard) {
            $view->twoBoard(
                $this->playerCommand->getBoard(),
                $this->computerCommand->getBoard()
            );
        } else {
            $view->boardAndShadow($this->playerCommand->getBoard());
        }


        echo 'Enter new ship coordinate: ';
        
        $this->playerCommand->getMessages()->clear();
    }

    public function execute(): void
    {
        $input = ConsoleInput::init()->toString();

        //Устанавливаем корабли на поле
        if (!$this->playerShipsSetOnBoard) {
            
            //!!!!!Установка тестовых кораблей
            foreach ($this->testShips as $ship) {
                $this->playerCommand->addShipOnBoard($ship['y'], $ship['x'], $ship['size'], $ship['orient']);
            }


            //Получаем параметры нового корабля
            if (ConsoleInput::init()->isParameters()) {
                $coord = ConsoleInput::init()->getParameters($input);

                //Создаем корабль по переданным параметрам
                $this->playerCommand->addShipOnBoard($coord['y'], $coord['x'], $coord['size'], $coord['orientation']);
            }

            //Обновление информации о кораблях на доске
            $this->playerCommand->updateBoardInfo();

        }

        //Если все корабли установлены, начинаем игру
        if ($this->playerShipsSetOnBoard) {
            if (ConsoleInput::init()->isCoordinate()) {
                $coord = ConsoleInput::init()->getCoordinate($input);

                //Урон по своим кораблям!!!!!
                $this->computerCommand->fire($coord['y'], $coord['x']);
            }
        }

        //Подготавливаем данные для игры
        $this->dataPrepare();
    }

    private function dataPrepare(): void
    {
        //Устанавливаем корабли для компьютерного игрока
        if (!$this->computerShipsSetOnBoard) {

            $this->bot->generateShips($this->computerCommand);
            $this->computerCommand->updateBoardInfo();
            $this->computerShipsSetOnBoard = true;

        }

        //Если все корабли установлены
        if ($this->playerCommand->allShipSet()) {

            //Подготовка карты урона
            $this->playerCommand->prepareShipDamageManager();
            $this->computerCommand->prepareShipDamageManager();

            $this->playerShipsSetOnBoard = true;
        }
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

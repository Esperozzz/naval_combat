<?php

class NewGameController extends Controller
{
    private $bot;
    private $playerCommand;
    private $computerCommand;
    private $playerShipsSetOnBoard = false;
    private $computerShipsSetOnBoard = false;
    
    private $messageManager;
    
    private $testShips;

    public function __construct()
    {
        $this->playerCommand = new GameCommand();
        $this->computerCommand = new GameCommand();
        $this->bot = new GameBot($this->computerCommand);
        
        $this->messageManager = new MessageManager();
        
        $ships = [
            ['y' => 70, 'x' => 5, 'size' => 4, 'orient' => 1],
            ['y' => 65, 'x' => 2, 'size' => 1, 'orient' => 0],
            ['y' => 65, 'x' => 7, 'size' => 3, 'orient' => 1],
            //['y' => 67, 'x' => 1, 'size' => 1, 'orient' => 1],
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
        $computerMessage = $this->computerCommand->getMessages()->get();
        $playerMessage = $this->computerCommand->getMessages()->get();
        $view->setMessage($computerMessage);
        
        //Вывод игровых полей
        if ($this->playerShipsSetOnBoard) {
            $view->twoBoard(
                $this->playerCommand->getBoard(),
                $this->computerCommand->getBoard()
            );
        } else {
            $view->boardAndShadow($this->playerCommand->getBoard());
        }
        
        $this->computerCommand->getMessages()->clear();
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

                //Урон игрока по полю компьютера
                $this->computerCommand->fire($coord['y'], $coord['x']);
                
                //Урон компьютера по полю игрока
                $this->bot->addFire($this->playerCommand);
            }
        }

        //Подготавливаем данные для игры
        $this->dataPrepare();
    }

    private function dataPrepare(): void
    {
        //Устанавливаем корабли для компьютерного игрока
        if (!$this->computerShipsSetOnBoard) {

            $this->bot->generateShips();
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
    
    public function loopIsInterrupted(): bool
    {
        return false;
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

<?php

class NewGameController extends Controller
{
    private $playerCommand;
    private $damageMapIsSet = false;
    private $shipsSetOnBorad = false;

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

        //Устанавливаем корабли на поле
        if (!$this->shipsSetOnBorad) {

            //Получаем параметры нового корабля
            if (ConsoleInput::init()->isParameters()) {
                $coord = ConsoleInput::init()->getParameters($input);

                //Создаем корабль по переданным параметрам
                $this->playerCommand->addShipOnBoard($coord['y'], $coord['x'], $coord['size'], $coord['orientation']);
            }

            //Обновление информации о кораблях на доске
            $this->playerCommand->updateBoardInfo();

            //Если все корабли установлены
            if ($this->playerCommand->allShipSet()) {

                //Подготовка карты урона
                $this->playerCommand->prepareShipDamageManager();
                $this->shipsSetOnBorad = true;
            }
        }

        //Если все корабли установлены, начинаем игру
        if ($this->shipsSetOnBorad) {
            if (ConsoleInput::init()->isCoordinate()) {
                $coord = ConsoleInput::init()->getCoordinate($input);

                //Урон по своим кораблям!!!!!
                $this->playerCommand->fire($coord['y'], $coord['x']);
            }
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

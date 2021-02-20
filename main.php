<?php

error_reporting(-1);

include_once 'src/NavalCombat/Router/GameRouter.php';
include_once 'src/NavalCombat/Router/Controllers/Controller.php';
include_once 'src/NavalCombat/Router/Controllers/NewGameController.php';
include_once 'src/NavalCombat/Router/Controllers/ExitController.php';
include_once 'src/NavalCombat/Router/Controllers/DefaultController.php';
include_once 'src/NavalCombat/Message/MessageList.php';
include_once 'src/NavalCombat/Message/GameMessage.php';
include_once 'src/NavalCombat/Ship/NamedFixedList.php';
include_once 'src/NavalCombat/GameCommand/GameCommand.php';
include_once 'src/NavalCombat/Message/GameMessage.php';
include_once 'src/NavalCombat/Console/ConsoleInput.php';
include_once 'src/NavalCombat/GameBoard/GameBoard.php';
include_once 'src/NavalCombat/GameBoard/GameBoardSizeOptions.php';
include_once 'src/NavalCombat/Ship/ShipStorage.php';
include_once 'src/NavalCombat/Ship/ShipDamageManager.php';
include_once 'src/NavalCombat/Ship/Dockyard.php';
include_once 'src/NavalCombat/Ship/Ship.php';
include_once 'src/NavalCombat/Ship/Wreck.php';
include_once 'src/NavalCombat/Ship/Boat.php';
include_once 'src/NavalCombat/Ship/Destroyer.php';
include_once 'src/NavalCombat/Ship/Cruiser.php';
include_once 'src/NavalCombat/Ship/Battleship.php';
include_once 'src/NavalCombat/View/View.php';
include_once 'src/NavalCombat/GameBot/GameBot.php';

$gBot = new GameBot();
$view = new View(false);
$GC = new GameCommand();

/* Начинает установку с малого корабля
$shipSize = 1;
$iteration = 1;

for ($count = 4; $count >= 1; $count--) {
    for ($k = 0; $k < $count; ) {
        $ship = $gBot->generateShipCoordinate($shipSize);
        if ($GC->addShipOnBoard($ship['y'], $ship['x'], $ship['size'], $ship['orientation'])) {
            $k++;
        }
        
        $GC->updateBoardInfo();
        $view->boardAndShadow($GC->getBoard());
        sleep(1);
        //echo $iteration++;
        //echo PHP_EOL;
        
    }
    
    $shipSize++;
    if ($GC->allShipSet()) {
        break;
    }
}
*/

//Начинает установку с большого корабля

$shipSize = 4;
$iteration = 1;

for ($count = 1; $count <= 4; $count++) {
    for ($k = $count; $k > 0; ) {
        $ship = $gBot->generateShipCoordinate($shipSize);
        if ($GC->addShipOnBoard($ship['y'], $ship['x'], $ship['size'], $ship['orientation'])) {
            $k--;
        }
    }
    
    $shipSize--;
    if ($GC->allShipSet()) {
        break;
    }
}

$GC->updateBoardInfo();
$view->boardAndShadow($GC->getBoard());



$menu = [
    1 => 'Start game',
    2 => 'Options',
    'x' => 'Exit'
];

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

//$router = new GameRouter();
//$router->addCommand(new NewGameController());
//$router->addCommand(new ExitController());

//$router->runGame();


    //Получить ввод опции
    //Инициализировать новый контроллер если введены другие опции
        //Если не введены, повторить цикл с текущим контроллером
    //Подготовить рабочие данные/инициализировать необходимые классы/обработать ввод
    //Выполнить оперпцию
    //Очистить экран
    //Вывести данные на экран
    //Проверить, закончен ли цикл, кинуть break;
    //Сохранить данные для следующей итерации


    //1. Вывести общее меню
    //2. Новая игра
    //3. Запросить расстановку кораблей    
        //3.a Получить координаты корабля
            //3.a.1 Если координаты не корректные, вернуться в предыдущий пункт (3.a)
        //3.б Обновить доску с кораблями
        //3.в Провертить, все ли корабли установлены
            //3.в.1 Если нет, повторить итерацию (3.а)
        //3.г Установить корабли компьютера
    //4. Бросить жребий, кто ходит первый (от жребия определить очередность пунктов 5 и 7)
    //5. Запросить ход игрока
        //5.а Получить координаты выстрела
        //5.б Сверить выстрел с картой игры
            //5.б.1 Если попал вывести сообщение
            //5.б.2 Проверить, все ли корабли убиты
            //5.б.3 Вывести сообщение о попадании
            //5.б.4 Повторить цикл (5.а)
            //5.в.1 Если не попал, вывести сообщение
    //6. Отметить выстрел на поле игры компьютера
    //7. Повторить пункты 5 для компьютера
    //8. Когда игрок или компьютер победит, показать расположение кораблей на поле

    //Опции
    //Выход



/*
for (;;) {
    
    $view->clearDisplay();
    
    $view->gameMenu($menu);
    
    echo 'Select option: ';
    $input->read();
    $arguments = $input->getString();
    
    switch ($arguments) {
        case (1):
        
            for (;;) {
                //Вывод
                $view->clearDisplay();
                $view->boardAndShadow($gm->getPlayerBoard());
                echo 'Enter fire: ';
                
                //Ввод
                $input->read();
                $arguments = $input->getString();

                //Получение координат выстрела
                if ($input->isCoordinate()) {
                    $coord = $input->convertToCoordinate($arguments);
                    
                    $gm->fire($coord['y'], $coord['x']);
                }
                
                if ($arguments == 'x') {
                    break;
                }
            }
            
            break;
        case (2):
            echo 'Options' .  PHP_EOL;
            break;
        case ('x'):
            exit();
        default:
            break;
    }
}
*/






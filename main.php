<?php

error_reporting(-1);

include_once 'src/NavalCombat/GameMaker/GameMaker.php';
include_once 'src/NavalCombat/Console/ConsoleInput.php';
include_once 'src/NavalCombat/GameBoard/GameBoard.php';
include_once 'src/NavalCombat/GameBoard/GameBoardSizeOptions.php';
include_once 'src/NavalCombat/Ship/ShipStorage.php';
include_once 'src/NavalCombat/Ship/ShipDamageManager.php';
include_once 'src/NavalCombat/Structures/NamedFixedList.php';
include_once 'src/NavalCombat/Ship/Dockyard.php';
include_once 'src/NavalCombat/Ship/Ship.php';
include_once 'src/NavalCombat/Ship/Boat.php';
include_once 'src/NavalCombat/Ship/Destroyer.php';
include_once 'src/NavalCombat/Ship/Cruiser.php';
include_once 'src/NavalCombat/Ship/Battleship.php';
include_once 'src/NavalCombat/View/View.php';

$input = new ConsoleInput();
$view = new View(true);
$gm = new GameMaker();

$menu = [
    1 => 'Start game',
    2 => 'Options',
    'x' => 'Exit'
];

$ships = [
    //['y' => 70, 'x' => 5, 'size' => 4, 'orient' => 1],
    //['y' => 65, 'x' => 2, 'size' => 1, 'orient' => 0],
    //['y' => 65, 'x' => 7, 'size' => 3, 'orient' => 1],
    //['y' => 67, 'x' => 1, 'size' => 1, 'orient' => 1],
    //['y' => 68, 'x' => 3, 'size' => 1, 'orient' => 1],
    //['y' => 69, 'x' => 1, 'size' => 1, 'orient' => 1],
    //['y' => 70, 'x' => 8, 'size' => 2, 'orient' => 0],
    //['y' => 74, 'x' => 1, 'size' => 2, 'orient' => 0],
    //['y' => 71, 'x' => 1, 'size' => 3, 'orient' => 0],
    ['y' => 74, 'x' => 8, 'size' => 2, 'orient' => 0],
];

foreach ($ships as $s) {
    $gm->playerShipAdd($s['y'], $s['x'], $s['size'], $s['orient']);
}

$gm->allShipSet();


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
                if ($input->isCoordinate($arguments)) {
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







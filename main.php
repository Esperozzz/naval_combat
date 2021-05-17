<?php

error_reporting(-1);

include_once 'src/NavalCombat/Router/GameRouter.php';
include_once 'src/NavalCombat/Router/Controllers/Controller.php';
include_once 'src/NavalCombat/Router/Controllers/NewGameController.php';
include_once 'src/NavalCombat/Router/Controllers/ExitController.php';
include_once 'src/NavalCombat/Router/Controllers/DefaultController.php';
include_once 'src/NavalCombat/Message/MessageList.php';
include_once 'src/NavalCombat/Message/GameMessage.php';
include_once 'src/NavalCombat/Message/MessageManager.php';
include_once 'src/NavalCombat/Ship/NamedFixedList.php';
include_once 'src/NavalCombat/GameCommand/GameCommand.php';
include_once 'src/NavalCombat/Message/GameMessage.php';
include_once 'src/NavalCombat/Console/ConsoleInput.php';
include_once 'src/NavalCombat/GameBoard/GameBoard.php';
include_once 'src/NavalCombat/GameBoard/GameBoardSizeOptions.php';
include_once 'src/NavalCombat/Ship/ShipStorage.php';
include_once 'src/NavalCombat/Ship/ShipDamageManager.php';
include_once 'src/NavalCombat/Ship/Dockyard.php';
include_once 'src/NavalCombat/Ship/ShipTypes/Ship.php';
include_once 'src/NavalCombat/Ship/ShipTypes/Wreck.php';
include_once 'src/NavalCombat/Ship/ShipTypes/Boat.php';
include_once 'src/NavalCombat/Ship/ShipTypes/Destroyer.php';
include_once 'src/NavalCombat/Ship/ShipTypes/Cruiser.php';
include_once 'src/NavalCombat/Ship/ShipTypes/Battleship.php';
include_once 'src/NavalCombat/View/View.php';
include_once 'src/NavalCombat/GameBot/GameBot.php';

try {

$router = new GameRouter();
$router->addController(new NewGameController());
$router->addController(new ExitController());
$router->runGame();

} catch (Exception $e) {
    echo $e->getMessage();
}

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


<?php

error_reporting(-1);

include_once 'src/NavalCombat/GameMaker/GameMaker.php';
include_once 'src/NavalCombat/Console/ConsoleManager.php';
include_once 'src/NavalCombat/GameBoard/GameBoard.php';
include_once 'src/NavalCombat/GameBoard/GameBoardSizeOptions.php';
include_once 'src/NavalCombat/GameBoard/ShipStorage.php';
include_once 'src/NavalCombat/GameBoard/NamedFixedList.php';
include_once 'src/NavalCombat/Ship/Dockyard.php';
include_once 'src/NavalCombat/Ship/Ship.php';
include_once 'src/NavalCombat/Ship/Boat.php';
include_once 'src/NavalCombat/Ship/Destroyer.php';
include_once 'src/NavalCombat/Ship/Cruiser.php';
include_once 'src/NavalCombat/Ship/Battleship.php';
include_once 'src/NavalCombat/View/View.php';

$console = ConsoleManager::start();
$view = new View(true);
$gm = new GameMaker();

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

foreach ($ships as $s) {
    $gm->playerShipAdd($s['y'], $s['x'], $s['size'], $s['orient']);
}

$gm->allShipSet();

for (;;) {
    
    $view->clearDisplay();
    
    $view->gameMenu($menu);
    
    echo 'Select option: ';
    $console->getInput();
    $input = $console->returnInput();
    
    switch ($input) {
        case (1):
        
            for (;;) {
                //Вывод
                $view->clearDisplay();
                $view->boardAndShadow($gm->getPlayerBoard());
                echo 'Enter fire: ';
                
                //Ввод
                $console->getInput();
                $input = $console->returnInput();
                
                if ($console->isCoordinate($input)) {
                    $coord = $console->convertToCoordinate($input);
                    $gm->fire($coord['y'], $coord['x']);
                }
                
                if ($input == 'x') {
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







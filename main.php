<?php

error_reporting(-1);

include_once 'src/NavalCombat/Console/ConsoleManager.php';
include_once 'src/NavalCombat/GameBoard/GameBoard.php';
include_once 'src/NavalCombat/GameBoard/GameBoardSizeOptions.php';
include_once 'src/NavalCombat/Ship/Dockyard.php';
include_once 'src/NavalCombat/Ship/Ship.php';
include_once 'src/NavalCombat/Ship/Boat.php';
include_once 'src/NavalCombat/Ship/Destroyer.php';
include_once 'src/NavalCombat/Ship/Cruiser.php';
include_once 'src/NavalCombat/Ship/Battleship.php';
include_once 'src/NavalCombat/View/View.php';

$console = ConsoleManager::start();

$C = 67;
$E = 69;
$J = 74;
$ERR = 74;

$boardOne = new GameBoard();
$boardTwo = new GameBoard();

$options1 = $boardOne->getSizeOptions();
$options2 = $boardTwo->getSizeOptions();

$dock1 = new Dockyard($options1);
$dock2 = new Dockyard($options2);

$view = new View();

$ship11 = $dock1->constructShip(73, 10, 2, 1);
$boardOne->addShip($ship11);

$ship21 = $dock1->constructShip(72, 5, 4, 0);
$boardOne->addShip($ship21);

$ship31 = $dock1->constructShip(70, 6, 1, 0);
$boardOne->addShip($ship31);

$ship41 = $dock1->constructShip(69, 10, 3, 1);
$boardOne->addShip($ship41);

$boardOne->updateShipsPosition();

/*

$ship21 = $dock1->constructShip($E, 1, 4, 0);
$ship31 = $dock1->constructShip($E, 6, 2, 1);
$ship41 = $dock1->constructShip($J, 10, 1, 1);
$badShip1 = $dock1->constructShip($ERR, 1, 4, 0);




$boardOne->addShip($ship31);
$boardOne->addShip($ship41);
$boardOne->addShip($badShip1);
*/

/*
$ship12 = $dock2->constructShip(65, 9, 2, 0);
$ship22 = $dock2->constructShip($E, 1, 4, 0);
$ship32 = $dock2->constructShip($E, 6, 2, 1);

$boardTwo->addShip($ship12);
$boardTwo->addShip($ship22);
$boardTwo->addShip($ship32);
*/

for ($i = $C - 1, $k = 3; $i < $J; $i++, $k++) {
    if (!$boardOne->addFire($i, $k)) {
        throw new Exception('Fire past the game board');
    }
}

$boardOne->addFire(70, 6);

$x = '';
$y = '';

//$view->twoBoard($boardOne, $boardTwo);
$view->boardAndShadow($boardOne);



/*
for (;;) {

    $boardOne->update();
    $boardTwo->update();
    $view->twoBoard($boardOne, $boardTwo);



    $stdin = fopen('php://stdin', 'r');
    echo PHP_EOL;
    echo "Enter text: ";
    $result = stream_get_contents($stdin, 3);
    
    $entered = str_split(strtoupper($result));
    if ($entered[0] == chr(88)) {
        $view->clearDisplay();
        exit();
    }
    //var_dump($entered);
    $y = ord($entered[0]);
    $x = $entered[1];

    if (!$boardOne->addFire($y, $x)) {
        throw new Exception('Fire past the game board');
    }
}*/

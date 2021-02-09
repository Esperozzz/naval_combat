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
$view = new View();

$ships = [
    [
        'y' => 70,
        'x' => 5,
        'size' => 4,
        'orient' => 1
    ],
    [
        'y' => 65,
        'x' => 2,
        'size' => 1,
        'orient' => 0
    ],
    [
        'y' => 65,
        'x' => 7,
        'size' => 3,
        'orient' => 1
    ],
    [
        'y' => 67,
        'x' => 1,
        'size' => 1,
        'orient' => 1
    ],
    [
        'y' => 68,
        'x' => 3,
        'size' => 1,
        'orient' => 1
    ]
];

$gm = new GameMaker();
foreach ($ships as $s) {
    $gm->playerShipAdd($s['y'], $s['x'], $s['size'], $s['orient']);
}

$gm->allShipSet();

$view->boardAndShadow($gm->getPlayerBoard());



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

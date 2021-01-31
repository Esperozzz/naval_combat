<?php

error_reporting(-1);

define('ASCII_COMMERCIAL_AT', 64);

include_once 'src/NavalCombat/GameBoard/GameBoard.php';
include_once 'src/NavalCombat/Ship/Ship.php';
include_once 'src/NavalCombat/View/ViewBoard.php';

$clearBoard = new GameBoard();
$clearBoard->get();

$C = 67;
$E = 69;
$J = 65;
$ERR = 74;

$ship1 = new Ship ($C, 4, 2, 0);
$ship2 = new Ship ($E, 1, 4, 0);
$ship3 = new Ship ($E, 6, 2, 1);
$ship4 = new Ship ($J, 10, 1, 1);
$badShip = new Ship($ERR, 1, 4, 0);

$clearBoard->addShip($ship1);
$clearBoard->addShip($ship2);
$clearBoard->addShip($ship3);
$clearBoard->addShip($ship4);
$clearBoard->addShip($badShip);




foreach ($clearBoard->get() as $rowKey => $rows) {
    if ($rowKey === ASCII_COMMERCIAL_AT) {
        echo '  ';
    } else {
        echo chr($rowKey) . ' ';
    }
    foreach ($rows as $colKey => $col) {
        if ($rowKey === ASCII_COMMERCIAL_AT) {
            echo $colKey . ' ';
        } else {
            echo $col . ' ';
        }
    }
    echo "\n";
}

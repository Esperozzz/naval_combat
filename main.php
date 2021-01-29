<?php

error_reporting(-1);

define('ASCII_COMMERCIAL_AT', 64);

include_once 'src/NavalCombat/GameBoard/GameBoard.php';
include_once 'src/NavalCombat/Ship/Ship.php';
include_once 'src/NavalCombat/View/ViewBoard.php';

$clearBoard = new GameBoard();
$clearBoard->get();

$C = 67;
$F = 70;

$ship1 = new Ship ($C, 4, 2, 0);
$ship2 = new Ship ($F, 2, 4, 0);
$ship3 = new Ship ($F, 6, 3, 1);

$clearBoard->addShip($ship1);
$clearBoard->addShip($ship2);
$clearBoard->addShip($ship3);




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

<?php

class View
{
    private const ASCII_COMMERCIAL_AT = 64;
    
    private const EMPTY_CELL = '.';
    private const SHIP_CELL = 'H';
    private const DESTROY_CELL = 'X';
    private const MISS_CELL = 'o';
    
    private $boardOne;
    private $boardTwo;
    
    public function oneBoard(GameBoard $board): void
    {
        foreach ($board->get() as $rowKey => $rows) {
            $this->viewLeftBoard($rowKey);
            $this->viewXLine($rows, $rowKey);
            echo PHP_EOL;
        }
    }
    
    public function twoBoard(GameBoard $boardOne, GameBoard $boardTwo): void
    {
        $boardOne = $boardOne->get();
        $boardTwo = $boardTwo->get();
        
        foreach ($boardOne as $rowKey => $rows) {
            $this->viewLeftBoard($rowKey);
            $this->viewXLine($boardOne[$rowKey], $rowKey);
            
            echo '  ';
            
            $this->viewLeftBoard($rowKey);
            $this->viewXLine($boardTwo[$rowKey], $rowKey);
            
            echo PHP_EOL;
        }
    }
    
    public function viewXLine(array $arr, $rowKey): void
    {
        foreach ($arr as $colKey => $col) {
            $this->viewTopBoard($rowKey, $colKey, $col);
        }
    }
    
    public function viewTopBoard($rowKey, $colKey, $col): void
    {
        if ($rowKey === self::ASCII_COMMERCIAL_AT) {
                echo $colKey . ' ';
            } else {
                echo $col . ' ';
            }
    }
    
    public function viewLeftBoard($key): void
    {
        if ($key === self::ASCII_COMMERCIAL_AT) {
                echo ' ';
            } else {
                echo chr($key) . ' ';
            }
    }
}

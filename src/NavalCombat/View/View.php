<?php

class View
{
    private const ASCII_COMMERCIAL_AT = 64;

    private const LINUX_OS = '';
    private const WIN_OS = 'Windows_NT';

    private const EMPTY_CELL = '.';
    private const SHIP_CELL = 'H';
    private const DESTROY_CELL = 'X';
    private const MISS_CELL = 'o';
    
    private $boardOne;
    private $boardTwo;
    
    private $debugOn;
    
    public function __construct(bool $debugOn = true)
    {
        $this->debugOn = $debugOn;
    }
    
    public function twoBoard(GameBoard $boardOne, GameBoard $boardTwo): void
    {
        $this->clearDisplay();

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

    public function boardAndShadow(GameBoard $boardOne): void
    {
        $this->clearDisplay();

        $board = $boardOne->get();
        $shadow = $boardOne->getShadowMap();

        foreach ($board as $rowKey => $rows) {
            $this->viewLeftBoard($rowKey);
            $this->viewXLine($board[$rowKey], $rowKey);

            echo '  ';

            $this->viewLeftBoard($rowKey);
            $this->viewXLine($shadow[$rowKey], $rowKey);

            echo PHP_EOL;
        }
    }
    
    public function gameMenu(array $menu): void
    {
        foreach ($menu as $key => $option) {
            echo "[{$key}] $option" . PHP_EOL;
        }
    }
    
    public function clearDisplay(): void
    {
        if ($this->debugOn) {
            return;
        }
        
        if ($this->getOS() === self::WIN_OS) {
            system('CLS');
        } else {
            system('clear');
        }
    }
    
    private function viewXLine(array $arr, $rowKey): void
    {
        foreach ($arr as $colKey => $col) {
            $this->viewTopBoard($rowKey, $colKey, $col);
        }
    }
    
    private function viewTopBoard($rowKey, $colKey, $col): void
    {
        if ($rowKey === self::ASCII_COMMERCIAL_AT) {
                echo $colKey . ' ';
            } else {
                echo $col . ' ';
            }
    }
    
    private function viewLeftBoard($key): void
    {
        if ($key === self::ASCII_COMMERCIAL_AT) {
                echo ' ';
            } else {
                echo chr($key) . ' ';
            }
    }

    private function getOS(): string
    {
        return $_SERVER['OS'] ?? '';
    }
}

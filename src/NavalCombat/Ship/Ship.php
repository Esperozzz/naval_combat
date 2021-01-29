<?php

class Ship
{
    private const VERTICAL_ORIENTATION = 1;
    private const HORIZONTAL_ORIENTATION = 0;
    
    private const VERTICAL_UPPER_BOUND = 65;
    private const VERTICAL_LOWER_BOUND = 74;
    private const HORIZONTAL_UPPER_BOUND = 1;
    private const HORIZONTAL_LOWER_BOUND = 10;
    
    private $startY;
    private $startX;
    private $size;
    private $orientation;
    
    private $cells = [];
    
    public function __construct($startY, $startX, $size, $orientation)
    {
        $this->startY = $startY;
        $this->startX = $startX;
        $this->size = $size;
        $this->orientation = $orientation;
    }
    
    public function make()
    {
        if ($this->orientation === self::HORIZONTAL_ORIENTATION) {
            $this->makeVertical();
        } else {
            $this->makeHorizontal();
        }
        return $this->cells;
    }
    
    public function isCorrect()
    {
        
        
        return;
    }
    
    public function isCorrectFirstPoint(): bool
    {
        return ($this->startY >= self::VERTICAL_UPPER_BOUND) && ($this->startY <= self::VERTICAL_LOWER_BOUND);
    }
    
    public function isCorrectLastPoint(): bool
    {
        $endY = $this->startY + $size;
        $endX = $this->startX + $size;
        
        return ($endY >= self::VERTICAL_UPPER_BOUND) && ($endY <= self::VERTICAL_LOWER_BOUND);
    }
    
    /**
     * Создает поля для корабля вертикально
     */
    private function makeVertical(): bool
    {
        if (($this->startY >= self::VERTICAL_UPPER_BOUND) && ($this->startY <= self::VERTICAL_LOWER_BOUND)) {
            $k = 0;
            $lastVerticalCellShip = $this->startY + $this->size;
            for ($i = $this->startY; $i < $lastVerticalCellShip; $i++) {
                $this->cells[$k]['row'] = $i;
                $this->cells[$k]['col'] = $this->startX;
                $k++;
            }
            return true;
        }
        return false;
    }
    
    /**
     * Создает поля для корабля горизонтально
     */
    private function makeHorizontal()
    {
        if (($this->startX >= self::HORIZONTAL_UPPER_BOUND) && ($this->startX <= self::HORIZONTAL_LOWER_BOUND)) {
            $k = 0;
            $lastHorisontalCellShip = $this->startX + $this->size;
            for ($i = $this->startX; $i < $lastHorisontalCellShip; $i++) {
                $this->cells[$k]['row'] = $this->startY;
                $this->cells[$k]['col'] = $i;
                $k++;
            }
            return true;
        }
        return false;
    }
    
    public function lastCell()
    {

    }
}

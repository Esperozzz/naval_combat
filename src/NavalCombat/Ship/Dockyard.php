<?php

class Dockyard
{
    private const Y_ORIENTATION = 1;
    private const X_ORIENTATION = 0;
    
    private const BOT_SIZE = 1;
    private const DESTROYER_SIZE = 2;
    private const CRUISER_SIZE = 3;
    private const BATTLESHIP_SIZE = 4;
    
    private const Y_LOW_BOUND = 65;
    private const Y_UP_BOUND = 74;
    private const X_LOW_BOUND = 1;
    private const X_UP_BOUND = 10;
    
    private $startPointY;
    private $startPointX;
    private $endPointY;
    private $endPointX;
    private $size;
    private $orientation;
    
    private $decks = [];

    public function __construct()
    {
        
    }

    /**
     *
     */
    public function constructShip($startY, $startX, $size, $orientation)
    {
        $this->prepareShip($startY, $startX, $size, $orientation);
        $shipType = null;
        switch ($size) {
            case (self::BOT_SIZE):
                $shipType = new Boat($this->decks);
                break;
            case (self::DESTROYER_SIZE):
                $shipType = new Destroyer($this->decks);
                break;
            case (self::CRUISER_SIZE):
                $shipType = new Cruiser($this->decks);
                break;
            case (self::BATTLESHIP_SIZE):
                $shipType = new Battleship($this->decks);
                break;
        }
        //Очищаем данные о ячейках корабля
        $this->decks = [];
        
        return $shipType;
    }

    /**
     *
     */
    private function prepareShip($startY, $startX, $size, $orientation)
    {
        $this->startPointY = $startY;
        $this->startPointX = $startX;
        $this->size = $size;
        $this->orientation = $orientation;

        $this->defineMaxSize();
        
        if ($orientation === self::Y_ORIENTATION) {
            $this->makeByY();
        } else {
            $this->makeByX();
        }
        
    }

    /**
     * Создает поля для корабля по вертикали (ось Y)
     */
    private function makeByY(): void
    {
        if ($this->sizePointsIsCorrect()) {
            for ($i = $this->startPointY, $deckKey = 0; $i <= $this->endPointY; $i++, $deckKey++) {
                $this->decks[$deckKey]['row'] = $i;
                $this->decks[$deckKey]['col'] = $this->startPointX;
            }
        }
    }
    
    /**
     * Создает поля для корабля по горизонтали (ось X)
     */
    private function makeByX(): void
    {
        if ($this->sizePointsIsCorrect()) {
            for ($i = $this->startPointX, $deckKey = 0; $i <= $this->endPointX; $i++, $deckKey++) {
                $this->decks[$deckKey]['row'] = $this->startPointY;
                $this->decks[$deckKey]['col'] = $i;
            }
        }
    }

    /**
     * Проверяет корректность начальной и конечной точек корабля
     *
     * @return bool
     */
    private function sizePointsIsCorrect(): bool
    {
        return $this->isFirstPoint() && $this->isLastPoint();
    }

    /**
     * Проверяет на корректность начальной точки корабля
     *
     * @return bool
     */
    private function isFirstPoint(): bool
    {
        return ($this->startPointY >= self::Y_LOW_BOUND && $this->startPointY <= self::Y_UP_BOUND)
            && ($this->startPointX >= self::X_LOW_BOUND && $this->startPointX <= self::X_UP_BOUND);
    }

    /**
     * Проверяет на корректность конечной точки корабля
     *
     * @return bool
     */
    private function isLastPoint(): bool
    {
        return ($this->endPointY >= self::Y_LOW_BOUND && $this->endPointY <= self::Y_UP_BOUND)
            && ($this->endPointX >= self::X_LOW_BOUND && $this->endPointX <= self::X_UP_BOUND);
    }

    /**
     * Определяет конечную точку корабля
     */
    private function defineMaxSize(): void
    {
        if ($this->orientation === self::Y_ORIENTATION) {
            $this->endPointY = ($this->startPointY + $this->size) - 1;
            $this->endPointX = $this->startPointX;
        } else {
            $this->endPointX = ($this->startPointX + $this->size) - 1;
            $this->endPointY = $this->startPointY;
        }
    }
}

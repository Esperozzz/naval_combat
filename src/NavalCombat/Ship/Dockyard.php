<?php

class Dockyard
{
    private const Y_ORIENTATION = 1;
    private const X_ORIENTATION = 0;
    
    private const BOT_SIZE = 1;
    private const DESTROYER_SIZE = 2;
    private const CRUISER_SIZE = 3;
    private const BATTLESHIP_SIZE = 4;
    
    private $startPointY;
    private $startPointX;
    private $endPointY;
    private $endPointX;
    private $size;
    private $orientation;
    
    private $decks = [];

    private $boardOptions;

    public function __construct(GameBoardOptions $BoardOptions)
    {
        $this->boardOptions = $BoardOptions;
    }

    /**
     * Создает необходимый тип корабля
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
     * Подготавливает данные для созлания корабля
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
                $this->decks[$deckKey]['y'] = $i;
                $this->decks[$deckKey]['x'] = $this->startPointX;
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
                $this->decks[$deckKey]['y'] = $this->startPointY;
                $this->decks[$deckKey]['x'] = $i;
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
        return ($this->startPointY >= $this->boardOptions->getYLowBound() && $this->startPointY <= $this->boardOptions->getYUpBound())
            && ($this->startPointX >= $this->boardOptions->getXLowBound() && $this->startPointX <= $this->boardOptions->getXUpBound());
    }

    /**
     * Проверяет на корректность конечной точки корабля
     *
     * @return bool
     */
    private function isLastPoint(): bool
    {
        return ($this->endPointY >= $this->boardOptions->getYLowBound() && $this->endPointY <= $this->boardOptions->getYUpBound())
            && ($this->endPointX >= $this->boardOptions->getXLowBound() && $this->endPointX <= $this->boardOptions->getXUpBound());
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

<?php

class Dockyard
{
    private const Y_ORIENTATION = 1;
    private const X_ORIENTATION = 0;
    
    private const BOAT_SIZE = 1;
    private const DESTROYER_SIZE = 2;
    private const CRUISER_SIZE = 3;
    private const BATTLESHIP_SIZE = 4;
    
    private $startPointY;
    private $startPointX;
    private $endPointY;
    private $endPointX;
    private $size;
    private $orientation;

    private $boardOptions;

    public function __construct(GameBoardOptions $BoardOptions)
    {
        $this->boardOptions = $BoardOptions;
    }

    /**
     * Создает необходимый тип корабля
     */
    public function constructShip($startY, $startX, $size, $orientation): Ship
    {
        $decks = $this->prepareShip($startY, $startX, $size, $orientation);
        
        $shadow = $this->prepareShadow($decks);
        
        switch ($size) {
            case (self::BOAT_SIZE):
                return new Boat($decks);
            case (self::DESTROYER_SIZE):
                return new Destroyer($decks);
            case (self::CRUISER_SIZE):
                return new Cruiser($decks);
            case (self::BATTLESHIP_SIZE):
                return new Battleship($decks);
            default:
                return null;
        }
    }

    public function prepareShadow(array $shipDecks)
    {
        $firstKey = 0;
        $lastKey = count($shipDecks) - 1;
        print_r($shipDecks);
        $startShadowY = $shipDecks[$firstKey]['y'] - 1;
        $startShadowX = $shipDecks[$firstKey]['x'] - 1;
        $endShadowY = $shipDecks[$lastKey]['y'] + 1;
        $endShadowX = $shipDecks[$lastKey]['x'] + 1;
        
        
        
        echo $startShadowY . PHP_EOL;
        echo $startShadowX . PHP_EOL;
        echo $endShadowY . PHP_EOL;
        echo $endShadowX . PHP_EOL;


        print_r($shadow);
        
    }

    /**
     * Подготавливает данные для созлания корабля
     */
    private function prepareShip($startY, $startX, $size, $orientation): array
    {
        $this->startPointY = $startY;
        $this->startPointX = $startX;
        $this->size = $size;
        $this->orientation = $orientation;

        $this->defineMaxSize();
        
        if ($orientation === self::Y_ORIENTATION) {
            return $this->makeByY();
        } else {
            return $this->makeByX();
        }
        
    }

    /**
     * Возвращает поля для корабля по вертикали (ось Y)
     */
    private function makeByY(): array
    {
        $decks = [];
        
        if ($this->sizePointsIsCorrect()) {
            for ($i = $this->startPointY, $deckKey = 0; $i <= $this->endPointY; $i++, $deckKey++) {
                $decks[$deckKey]['y'] = $i;
                $decks[$deckKey]['x'] = $this->startPointX;
            }
        }
        
        return $decks;
    }
    
    /**
     * Возвращает поля для корабля по горизонтали (ось X)
     */
    private function makeByX(): array
    {
        $decks = [];
        
        if ($this->sizePointsIsCorrect()) {
            for ($i = $this->startPointX, $deckKey = 0; $i <= $this->endPointX; $i++, $deckKey++) {
                $decks[$deckKey]['y'] = $this->startPointY;
                $decks[$deckKey]['x'] = $i;
            }
        }
        
        return $decks;
    }

    /**
     * Проверяет корректность начальной и конечной точек корабля
     */
    private function sizePointsIsCorrect(): bool
    {
        return $this->isFirstPoint() && $this->isLastPoint();
    }

    /**
     * Проверяет на корректность начальной точки корабля
     */
    private function isFirstPoint(): bool
    {
        return ($this->startPointY >= $this->boardOptions->getYLowBound() && $this->startPointY <= $this->boardOptions->getYUpBound())
            && ($this->startPointX >= $this->boardOptions->getXLowBound() && $this->startPointX <= $this->boardOptions->getXUpBound());
    }

    /**
     * Проверяет на корректность конечной точки корабля
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

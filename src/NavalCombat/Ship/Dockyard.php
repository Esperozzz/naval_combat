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

    private $boardSizeOptions;

    public function __construct(GameBoardSizeOptions $BoardSizeOptions)
    {
        $this->boardSizeOptions = $BoardSizeOptions;
    }

    /**
     * Создает необходимый тип корабля
     */
    public function constructShip(int $startY, int $startX, int $size, int $orientation = 1): Ship
    {
        $decks = $this->prepareShip($startY, $startX, $size, $orientation);
        $shadow = $this->prepareShadow($decks);
        
        switch ($size) {
            case (self::BOAT_SIZE):
                return new Boat($decks, $shadow);
            case (self::DESTROYER_SIZE):
                return new Destroyer($decks, $shadow);
            case (self::CRUISER_SIZE):
                return new Cruiser($decks, $shadow);
            case (self::BATTLESHIP_SIZE):
                return new Battleship($decks, $shadow);
            default:
                return null;
        }
    }

    /**
     *  Создает поля для корабля
     */
    private function prepareShadow(array $shipDecks): array
    {
        $shadow = [];
        $firstKey = 0;
        $lastKey = count($shipDecks) - 1;

        $startShadowY = $shipDecks[$firstKey]['y'] - 1;
        $startShadowX = $shipDecks[$firstKey]['x'] - 1;
        $endShadowY = $shipDecks[$lastKey]['y'] + 1;
        $endShadowX = $shipDecks[$lastKey]['x'] + 1;

        if ($startShadowY < $this->boardSizeOptions->getYLowBound()) {
            $startShadowY++;
        }

        if ($startShadowX < $this->boardSizeOptions->getXLowBound()) {
            $startShadowX++;
        }

        if ($endShadowY > $this->boardSizeOptions->getYUpBound()) {
            $endShadowY--;
        }

        if ($endShadowX > $this->boardSizeOptions->getXUpBound()) {
            $endShadowX--;
        }

        for ($y = $startShadowY; $y <= $endShadowY; $y++) {
            for ($x = $startShadowX; $x <= $endShadowX; $x++) {
                $shadow[] = [
                    'y' => $y,
                    'x' => $x,
                ];
            }
        }

        return $shadow;
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
        }
        return $this->makeByX();
    }

    /**
     * Возвращает поля для корабля по вертикали (ось Y)
     */
    private function makeByY(): array
    {
        $decks = [];
        
        if ($this->sizePointsIsCorrect()) {
            for ($i = $this->startPointY; $i <= $this->endPointY; $i++) {
                $decks[] = [
                    'y' => $i,
                    'x' => $this->startPointX
                ];
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
            for ($i = $this->startPointX; $i <= $this->endPointX; $i++) {
                $decks[] = [
                    'y' => $this->startPointY,
                    'x' => $i
                ];
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
        return ($this->startPointY >= $this->boardSizeOptions->getYLowBound() && $this->startPointY <= $this->boardSizeOptions->getYUpBound())
            && ($this->startPointX >= $this->boardSizeOptions->getXLowBound() && $this->startPointX <= $this->boardSizeOptions->getXUpBound());
    }

    /**
     * Проверяет на корректность конечной точки корабля
     */
    private function isLastPoint(): bool
    {
        return ($this->endPointY >= $this->boardSizeOptions->getYLowBound() && $this->endPointY <= $this->boardSizeOptions->getYUpBound())
            && ($this->endPointX >= $this->boardSizeOptions->getXLowBound() && $this->endPointX <= $this->boardSizeOptions->getXUpBound());
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

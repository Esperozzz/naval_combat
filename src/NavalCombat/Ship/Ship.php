<?php

class Ship
{
    private const Y_ORIENTATION = 1;
    private const X_ORIENTATION = 0;
    
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
    
    private $cells = [];

    /**
     * Ship constructor.
     * @param $startY
     * @param $startX
     * @param $size
     * @param $orientation
     */
    public function __construct($startY, $startX, $size, $orientation)
    {
        $this->startPointY = $startY;
        $this->startPointX = $startX;
        $this->size = $size;
        $this->orientation = $orientation;

        $this->defineMaxSize();
    }

    /**
     * @return array
     */
    public function make()
    {
        if ($this->orientation === self::Y_ORIENTATION) {
            $this->makeByY();
        } else {
            $this->makeByX();
        }
        return $this->cells;
    }
    
    /**
     * Создает поля для корабля по вертикали (ось Y)
     */
    private function makeByY(): void
    {
        if ($this->sizePointsIsCorrect()) {
            for ($i = $this->startPointY, $cellKey = 0; $i <= $this->endPointY; $i++, $cellKey++) {
                $this->cells[$cellKey]['row'] = $i;
                $this->cells[$cellKey]['col'] = $this->startPointX;
            }
        }
    }
    
    /**
     * Создает поля для корабля по горизонтали (ось X)
     */
    private function makeByX(): void
    {
        if ($this->sizePointsIsCorrect()) {
            for ($i = $this->startPointX, $cellKey = 0; $i <= $this->endPointX; $i++, $cellKey++) {
                $this->cells[$cellKey]['row'] = $this->startPointY;
                $this->cells[$cellKey]['col'] = $i;
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
     * Пределяет конечную точку корабля
     */
    private function defineMaxSize(): void
    {
        if ($this->orientation === self::Y_ORIENTATION) {
            $this->endPointY = ($this->startPointY + $this->size) - 1;
            $this->endPointX = $this->startPointX;
        } else {
            //X_ORIENTATION
            $this->endPointX = ($this->startPointX + $this->size) - 1;
            $this->endPointY = $this->startPointY;
        }
    }
}

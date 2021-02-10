<?php

class ShipStorage
{
    private const BATTLESHIP_LIMIT = 1;
    private const CRUISER_LIMIT = 2;
    private const DESTROYER_LIMIT = 3;
    private const BOAT_LIMIT = 4;

    private $ships;
    
    public function __construct()
    {
        $this->ships = [
            new NamedFixedList('boat', self::BOAT_LIMIT),
            new NamedFixedList('destroyer', self::DESTROYER_LIMIT),
            new NamedFixedList('cruiser', self::CRUISER_LIMIT),
            new NamedFixedList('battleship', self::BATTLESHIP_LIMIT)
        ];
    }
    
    /**
     * Добавляет корабль в соответствующую структуру
     */
    public function add(Ship $ship): bool
    {
        foreach ($this->ships as $shipList) {
            if ($ship->getType() === $shipList->getName()) {
                if ($shipList->addValue($ship)) {
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * Поверяет, достигнут ли лимит кораблей
     */
    public function isFull(): bool
    {
        foreach ($this->ships as $shipList) {
            if (!$shipList->isFull()) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Получить массив кораблей
     */
    public function getShips(): array
    {
        $result = [];
        foreach ($this->ships as $shipList) {
            foreach ($shipList->toArray() as $ship) {
                $result[] = $ship;
            }
        }
        return $result;
    }
}

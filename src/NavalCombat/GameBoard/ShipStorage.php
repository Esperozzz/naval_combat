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
    
    public function add(Ship $ship): bool
    {
        foreach ($this->ships as $shipList) {
            echo $ship->getType();
            echo ' = ';
            echo $shipList->getName();
            echo PHP_EOL;
            if ($ship->getType() === $shipList->getName()) {
                if ($shipList->addValue($ship)) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function isFull(): bool
    {
        foreach ($this->ships as $shipList) {
            if (!$shipList->isFull()) {
                return false;
            }
        }
        return true;
    }
    
    public function getShips(): array
    {
        
    }
}

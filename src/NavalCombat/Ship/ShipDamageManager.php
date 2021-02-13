<?php

class ShipDamageManager
{
    private $shipStorage;
    private $shipList;

    public function __construct(ShipStorage $storage)
    {
        $this->shipStorage = $storage;
    }

    /**
     * Устанавливает список полей кораблей
     */
    public function setDamageMap(): void
    {
        $this->shipList = $this->shipStorage->getShips();
    }

    /**
     * Проверяет, уничтожен ли корабль после выстрела
     */
    public function shipIsDestroyed($y, $x): bool
    {
        foreach ($this->shipList as $ship) {
            if ($ship->deckIsSet($y, $x) && !$ship->isDestroyed()) {
                $ship->hit();
                return $ship->isDestroyed();
            }
        }
        return false;
    }

    /**
     * Проверяет, уничтожены ли все корабли на поле
     */
    public function allShipsDestroyed(): bool
    {
        foreach ($this->shipList as $ship) {
            if (!$ship->isDestroyed()) {
                return false;
            }
        }
        return true;
    }
}

<?php

class ShipDamageManager
{
    private $shipStorage;
    private $shipList;
    private $damageMapIsSet = false;

    /**
     *
     */
    public function __construct(ShipStorage $storage)
    {
        $this->shipStorage = $storage;
    }

    /**
     * Разово устанавливает список полей кораблей
     */
    public function setDamageMap(): void
    {
        if (!$this->damageMapIsSet) {
            $this->shipList = $this->shipStorage->getShips();
            $this->damageMapIsSet = true;
        }
    }

    /**
     * Проверяет, уничтожен ли корабль после выстрела
     */
    public function shipIsDestroyed(int $y, int $x): bool
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

<?php

class ShipDamageManager
{
    private $shipList;
    
    public function __construct(ShipStorage $storage)
    {
        var_dump($storage);
        
        $this->shipList = $storage->getShips();
    }
    
    public function shipIsDestroyed($y, $x): bool
    {
        var_dump($this->shipList);
        
        foreach ($this->shipList as $ship) {
            if ($ship->deckIsSet($y, $x) && !$ship->isDestroyed()) {
                $ship->hit();
                return $ship->isDestroyed();
            }
        }
        
        var_dump($this->shipList);
        
        return false;
    }
}

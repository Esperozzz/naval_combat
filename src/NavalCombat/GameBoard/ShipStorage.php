<?php

class ShipStorage
{
    private const BATTLESHIP_LIMIT = 1;
    private const CRUISER_LIMIT = 2;
    private const DESTROYER_LIMIT = 3;
    private const BOAT_LIMIT = 4;

    private $boatKey = 0;
    private $boat;

    private $destroyerKey = 0;
    private $destroyer;

    private $cruiserKey = 0;
    private $cruiser;

    private $battleshipKey = 0;
    private $battleship;

    public function addBoat(Boat $ship)
    {
        if ($this->boatKey > self::BOAT_LIMIT) {
            $this->boat[$this->boatKey] = $ship;
            $this->boatKey++;
            return true;
        }
        return false;
    }

    public function addDestroyer(Destroyer $ship)
    {
        if ($this->destroyerKey > self::DESTROYER_LIMIT) {
            $this->destroyer[$this->destroyerKey] = $ship;
            $this->destroyerKey++;
            return true;
        }
        return false;
    }

    public function addCruiser(Cruiser $ship)
    {
        if ($this->boatKey > self::CRUISER_LIMIT) {
            $this->boat[$this->boatKey] = $ship;
            $this->boatKey++;
            return true;
        }
        return false;
    }

    public function addBattleship(Battleship $ship)
    {
        if ($this->boatKey > self::BATTLESHIP_LIMIT) {
            $this->boat[$this->boatKey] = $ship;
            $this->boatKey++;
            return true;
        }
        return false;
    }
}

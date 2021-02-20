<?php

class GameBot
{
    private const Y_LOW_BOUND = 65;
    private const Y_UP_BOUND = 74;
    private const X_LOW_BOUND = 1;
    private const X_UP_BOUND = 10;
    
    private const BATTLESHIP_LIMIT = 1;
    private const CRUISER_LIMIT = 2;
    private const DESTROYER_LIMIT = 3;
    private const BOAT_LIMIT = 4;
    
    private const BOAT_SIZE = 1;
    private const DESTROYER_SIZE = 2;
    private const CRUISER_SIZE = 3;
    private const BATTLESHIP_SIZE = 4;
    
    private const Y_ORIENTATION = 1;
    private const X_ORIENTATION = 0;
    
    private $battleship = 1;
    private $cruiser = 2;
    private $destroyer = 3;
    private $boat = 4;
    
    public function generateShipCoordinate($size)
    {
        $orientation = mt_rand(self::X_ORIENTATION, self::Y_ORIENTATION);
        
        if ((bool) $orientation) {
            $upY = self::Y_UP_BOUND - $size;
            $lowY = self::Y_LOW_BOUND;
            $upX = self::X_UP_BOUND;
            $lowX = self::X_LOW_BOUND;
        } else {
            $upY = self::Y_UP_BOUND;
            $lowY = self::Y_LOW_BOUND;
            $upX = self::X_UP_BOUND - $size;
            $lowX = self::X_LOW_BOUND;
        }
        
        $firtsPointY = mt_rand($lowY, $upY);
        $firtsPointX = mt_rand($lowX, $upX);
        
        return [
            'y' => $firtsPointY,
            'x' => $firtsPointX,
            'size' => $size,
            'orientation' => $orientation
        ];
    }
    
    
    
    
    public function shipCoordinateIsCorrect(bool $shipAccept): bool
    {
        if ($shipAccept) {

        }
    }
    
    public function shipTypeIsFull($shipType): bool
    {
        return $ship === 0;
    }
}

<?php

class GameBoardOptions
{
    private $yLowBound;
    private $xLowBound;
    private $yUpBound;
    private $xUpBound;
    
    public function __construct(int $yLow, int $xLow, int $yUp, int $xUp)
    {
        $this->yLowBound = $yLow;
        $this->xLowBound = $xLow;
        $this->yUpBound = $yUp;
        $this->xUpBound = $xUp;
    }
    
    public function getYLowBound(): int
    {
        return $this->yLowBound;
    }
    
    public function getXLowBound(): int
    {
        return $this->xLowBound;
    }
    
    public function getYUpBound(): int
    {
        return $this->yUpBound;
    }
    
    public function getXUpBound(): int
    {
        return $this->xUpBound;
    }
}

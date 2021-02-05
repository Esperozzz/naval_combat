<?php

class Ship
{
    private $decks = [];
    private $shadow = [];
    
    protected $size;
    
    public function __construct(array $decks, array $shadow)
    {
        $this->decks = $decks;
        $this->shadow = $shadow;
    }

    public function get(): array
    {
        return $this->decks;
    }

    public function getShadow(): array
    {
        return $this->shadow;
    }

    public function getSize(): int
    {
        return $this->size;
    }
    
}

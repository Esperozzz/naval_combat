<?php

class Ship
{
    private $decks = [];
    private $shadow = [];
    
    protected $size;
    
    public function __construct(array $decks)
    {
        $this->decks = $decks;
    }

    public function get(): array
    {
        return $this->decks;
    }
    
    public function getSize(): int
    {
        return $this->size;
    }
    
}

<?php

class Ship
{
    private $decks = [];
    private $shadow = [];
    
    protected $size;
    
    public function __construct($decks)
    {
        $this->decks = $decks;
    }

    public function get()
    {
        return $this->decks;
    }
    
    public function getSize(): int
    {
        return $this->size;
    }
    
}

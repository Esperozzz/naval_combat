<?php

class Ship
{
    private $decks = [];
    private $shadow = [];
    
    public function __construct($decks)
    {
        $this->decks = $decks;
    }
    
    public function get()
    {
        return $this->decks;
    }
}

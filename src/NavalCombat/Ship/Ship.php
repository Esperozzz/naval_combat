<?php

abstract class Ship
{
    protected $decks;
    protected $shadow;
    protected $size;

    /**
     *
     */
    public function __construct(array $decks, array $shadow)
    {
        $this->decks = $decks;
        $this->shadow = $shadow;
    }

    /**
     *
     */
    public function get(): array
    {
        return $this->decks;
    }

    /**
     *
     */
    public function getShadow(): array
    {
        return $this->shadow;
    }

    /**
     *
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     *
     */
    public function getType(): string
    {
        $explodeName = explode('\\',  get_class($this));
        return strtolower(array_pop($explodeName));
    }

    /**
     *
     */
    public function isDestroyed(): bool
    {
        return empty($this->decks);
    }
}

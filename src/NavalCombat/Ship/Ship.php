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
     * Получить массив ячеек корабля
     */
    public function get(): array
    {
        return $this->decks;
    }

    /**
     * Получить массив ячеек тени корабля
     */
    public function getShadow(): array
    {
        return $this->shadow;
    }

    /**
     * Получить размер корабля
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Получить имя типа корабля
     */
    public function getType(): string
    {
        $namespace = explode('\\',  get_class($this));
        return strtolower(array_pop($namespace));
    }

    /**
     * Проверяет массив ячеек корабля, пуст он или нет
     */
    public function isDestroyed(): bool
    {
        return empty($this->decks);
    }
}

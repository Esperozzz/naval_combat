<?php

class Ship
{
    protected $id;
    protected $size;
    protected $hits;
    protected $decks;
    protected $shadow;

    /**
     *
     */
    public function __construct(string $id, array $decks, array $shadow)
    {
        $this->id = $id;
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
     * Проверяет наличие указанной ячейки корабля
     */
    public function deckIsSet($y, $x): bool
    {
        foreach ($this->decks as $deck) {
            if (($deck['y'] == $y) && ($deck['x'] == $x)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Удаляет ячейку корабля
     */
    public function removeDeck($y, $x): void
    {
        foreach ($this->decks as $key => $deck) {
            if (($deck['y'] == $y) && ($deck['x'] == $x)) {
                unset($this->decks[$key]);
            }
        }
    }

    /**
     * Проверяет уничтожен ли корабль
     */
    public function isDestroyed(): bool
    {
        return $this->hits === 0;
    }
    
    /**
     * Возвращает уникальный id корабля
     */
    public function getId(): string
    {
        return $this->id;
    }
    
    private function hit(): void
    {
        $this->hits--;
    }
}

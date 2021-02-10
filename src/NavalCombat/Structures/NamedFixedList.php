<?php

class NamedFixedList
{
    private $name;
    private $limit;
    private $data = [];
    private $nextIndex = 0;

    /**
     *
     */
    public function __construct(string $name, int $limit)
    {
        $this->name = $name;
        $this->limit = $limit;
    }

    /**
     * Добавляет значение в структуру
     */
    public function addValue($value): bool
    {
        if (!$this->isFull()) {
            $this->data[$this->name][$this->nextIndex] = $value;
            $this->nextIndex++;
            return true;
        }
        return false;
    }

    /**
     * Преобразует структуру в массив
     */
    public function toArray(): array
    {
        return $this->data[$this->name] ?? [];
    }

    /**
     * Проверяет, заполнина ли структура
     */
    public function isFull(): bool
    {
        return $this->nextIndex >= $this->limit;
    }

    /**
     * Получает имя структуры
     */
    public function getName(): string
    {
        return $this->name;
    }
}

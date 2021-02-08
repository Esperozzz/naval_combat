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
     *
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
     *
     */
    public function toArray(): array
    {
        return $this->data[$this->name];
    }

    /**
     *
     */
    public function isFull(): bool
    {
        return $this->nextIndex >= $this->limit;
    }

    /**
     *
     */
    public function getName(): string
    {
        return $this->name;
    }
}

<?php

class MessageList
{
    private $index;
    protected $messages;

    public function __construct()
    {
        $this->index = 0;
        $this->messages = [];
    }

    public function getAll(): array
    {
        return $this->messages;
    }

    public function clear(): void
    {
        $this->messages = [];
        $this->index = 0;
    }

    public function add(string $message): void
    {
        $this->messages[$this->index++] = $message;
    }

    public function popLast(): string
    {
        if ($this->isEmpty()) {
            return '';
        }
        $temp = $this->messages[--$this->index];
        unset($this->messages[$this->index]);
        return $temp;
    }

    public function clearLast(): void
    {
        if (!$this->isEmpty()) {
            unset($this->messages[--$this->index]);
        }
    }

    public function isEmpty(): bool
    {
        return empty($this->messages);
    }
}

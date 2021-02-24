<?php

class MessageList
{
    protected $message;
    
    public function __construct()
    {
        $this->message = '';
    }
    
    public function get(): string
    {
        return $this->message;
    }

    public function clear(): void
    {
        $this->message = '';
    }

    public function add(string $message): void
    {
        $this->message = $message;
    }

    public function isEmpty(): bool
    {
        return $this->message === '';
    }
}

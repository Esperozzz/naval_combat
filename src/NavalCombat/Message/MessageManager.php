<?php

class MessageManager
{
    private $messages = [];
    
    /**
     * Добавить сообщение в список
     */
    public function add(int $key, $text): void
    {
        $this->keyIsPositiveNumber($key);
        
        if (!array_key_exists($key, $this->messages)) {
            $this->messages[$key] = $text;
            return;
        }
        throw new Exception(__CLASS__ . ': Key already exists.' . PHP_EOL);
    }
   
    /**
     * Получить сообщение по ключу из списка
     */ 
    public function get(int $key): string
    {
        if (!array_key_exists($key, $this->messages)) {
            return '';
        }
        return $this->messages[$key];
    }
    
    /**
     * Проверяет, является ли число ключа положительным
     */
    private function keyIsPositiveNumber(int $key): void
    {
        if ($key < 0) {
            throw new Exception(__CLASS__ . ': The key is not a positive number or is not zero.' . PHP_EOL);
        }
    }
}

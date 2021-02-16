<?php

class GameMenu
{
    private $options;
    private $command;
    
    public function __construct() {}
    
    public function addCommand(MenuOption $option)
    {
        $this->options[] = $option;
    }
    
    public function runGame()
    {
        for (;;) {
            
            $this->getInput();
            
        }
    }
    
    private function getInput()
    {
        $input = new consoleInput();
        $input->read();
        
        if ($inpit->) {

        }
    }
    
    public function readOption(string $command): bool
    {
        foreach ($this->options as $option) {
            if ($option->getCommandName() === $command) {
                $this->command = $option;
                return true;
            }
        }
        return false;
    }
    
    
    
    public function toArray(): array
    {
        $list = [];
        foreach ($this->options as $option) {
            $list[$option->getCommandName()] = $option->getName();
        }
        return $list;
    }
}

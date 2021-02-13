<?php

class GameMenu
{
    private $options;
    private $command;
    
    public function __construct()
    {
        
    }
    
    public function addCommand(MenuOption $option)
    {
        $this->options[] = $option;
    }
    
    public function readOption(string $command)
    {
        foreach ($this->options as $option) {
            if ($option->getCommandName() === $command) {
                $this->command = $option;
            }
        }
    }
    
    public function execCommand()
    {
        
    }
    
    public function make()
    {
        
    }
}

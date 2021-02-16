<?php

class ExitOption extends MenuOption
{
    protected $commandName = 'x';
    protected $optionName = 'Exit';
    
    public function execute()
    {
        exit();
    }
}

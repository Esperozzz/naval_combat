<?php

abstract class MenuOption
{
    public function getCommandName()
    {
        return $this->commandName;
    }
    
    public function getName()
    {
        return $this->optionName;
    }
    
    abstract public function execute();
    
}
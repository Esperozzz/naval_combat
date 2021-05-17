<?php

class DefaultController extends Controller
{
    public function getCommand(): string
    {
        return '@';
    }

    public function getName(): string
    {
        return '@';
    }

    public function view(View $view): void
    {
        $menu = self::getMenu();
        
        $options = $view->prepareMenuPanelOptions($menu);
        
        $view->mainMenu($options);
    }

    public function execute(): void {}
    public function saveData(): void {}
    
    public function loopIsInterrupted(): bool
    {
        return false;
    }
}

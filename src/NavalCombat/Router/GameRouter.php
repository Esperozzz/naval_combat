<?php

class GameRouter
{
    private const HIDDEN_CONTROLLER = '@';

    private $controllers;
    private $currentController;
    private $input;
    private $view;

    public function __construct()
    {
        $this->input = ConsoleInput::init();
        $this->view = new View(false);
        $this->currentController = new DefaultController();
    }
    
    public function addCommand(Controller $controller)
    {
        $this->controllers[] = $controller;
    }

    public function runGame()
    {

        for (;;) {

            //Подготовка данных
            $this->currentController->saveData();

            //View
            Controller::setMenu($this->makeMenu());
            $this->currentController->view($this->view);

            //Input
            $this->input->read();

            if ($this->input->isMenuOption()) {
                $input = $this->input->getMenuOption();
            } else {
                $input = '';
            }

            //Controller
            $this->setOption($input);

            //Execute
            $this->currentController->execute();
        }
    }










    public function setOption(string $command): bool
    {
        foreach ($this->controllers as $controller) {
            if ($controller->getCommand() === $command) {
                $this->currentController = $controller;
                return true;
            }
        }
        return false;
    }

    public function makeMenu(): array
    {
        $menu = [];
        foreach ($this->controllers as $controller) {
            if ($controller->getName() === self::HIDDEN_CONTROLLER) {
                continue;
            }
            $menu[$controller->getCommand()] = $controller->getName();
        }
        return $menu;
    }
}

<?php

abstract class Controller
{
    private static $menu;

    public static function setMenu(array $menu = []): void
    {
        self::$menu = $menu;
    }

    public static function getMenu(): array
    {
        return self::$menu;
    }

    abstract public function getCommand(): string;
    abstract public function getName(): string;
    abstract public function view(View $view): void;
    abstract public function execute(): void;
}

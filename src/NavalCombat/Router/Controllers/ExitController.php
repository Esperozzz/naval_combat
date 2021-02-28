<?php

class ExitController extends Controller
{
    public function getCommand(): string
    {
        return 'x';
    }

    public function getName(): string
    {
        return 'Exit';
    }

    public function execute(): void
    {
        exit();
    }

    public function view(View $view): void {}
    public function saveData(): void {}
    
    public function loopIsInterrupted(): bool
    {
        return false;
    }
}

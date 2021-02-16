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

    public function view(View $view): void
    {
        // TODO: Implement view() method.
    }

    public function execute(): void
    {
        exit();
    }
}

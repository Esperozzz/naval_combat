<?php

class NewGameController extends Controller
{
    private $playerBoard;

    public function __construct()
    {
        $this->playerBoard = new GameBoard();
    }

    public function getCommand(): string
    {
        return '1';
    }

    public function getName(): string
    {
        return 'New game';
    }

    public function view(View $view): void
    {
        $view->boardAndShadow($this->playerBoard);
    }

    public function execute(): void
    {

    }
}

<?php

/**
 * Класс манипулирует последоваетльностью игры (очередность хода)
 */
class GameRules
{
    private activePlayer;
    
    private activeStep;
    
    public function __construct()
    {
        $this->currentStep = StepGame::START;
    }
    
    /**
     * Метод определяет чей сейчас ход
     */
    public function whoseMove()
    {
        //
    }
    
    /**
     * Метод определяет текущий шаг игры
     */
    public function defineStep()
    {
        
    }
    
    public function getActiveStep(): int
    {
        return $this->activeStep;
    }
    
    public function executeStep()
    {
        switch ($this->activeStep) {
            case (StepGame::START):
                break;
            case (StepGame::INSTALLATION_OF_SHIPS):
                break;
            case (StepGame::SELECT_STARTING_PLAYER):
                break;
            case (StepGame::PLAYER_ACTION):
                break;
            case (StepGame::COUNTING_RESULT):
                break;
        }
    }
}

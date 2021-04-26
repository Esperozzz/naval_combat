<?php

/**
 * Класс перечисления шагов игры
 */
class StepGame
{
    const START = 0;
    
    /**
     * У тановка кораблей на поле
     */
    const INSTALLATION_OF_SHIPS = 1;
    
    /**
     * Определение игрока начинающего игру (бросание жребия)
     */
    const SELECT_STARTING_PLAYER = 2;
    
    /**
     * Обмен действиями игроков до окончания игры
     */
    const PLAYER_ACTION = 3;
    
    /**
     * Подссет результатов игры
     */
    const COUNTING_RESULT = 4;
}

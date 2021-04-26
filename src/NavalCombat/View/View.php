<?php

class View
{
    private const ASCII_COMMERCIAL_AT = 64;
    
    private const MESSAGE_PANEL_BOARD_LENGTH = 45;
    private const MESSAGE_PANEL_BOARD_VIEW = '*';
    
    private const MAX_LINES_IN_MESSAGE = 3;
    private const MAX_CHAR_IN_ONE_LINE = 41;
    private const MAX_MESSAGE_LENGTH = 123;

    private const LINUX_OS = '';
    private const WIN_OS = 'Windows_NT';

    private const EMPTY_CELL = '~';
    private const SHIP_CELL = 'H';
    private const DESTROY_CELL = 'X';
    private const MISS_CELL = '.';
    private const SHADOW_CELL = '*';
    
    private $boardOne;
    private $boardTwo;
    
    private $debugOn;
    
    private $hideShipsOnTwoBoard = true;
    
    private $ganeMenu;
    private $message = '';
    
    public function __construct(bool $debugOn = true)
    {
        $this->debugOn = $debugOn;
    }
    
    public function twoBoard(GameBoard $boardOne, GameBoard $boardTwo): void
    {
        $this->clearDisplay();

        $boardOne = $boardOne->get();
        $boardTwo = $boardTwo->get();
        
        $this->messagePanel($this->message);
        
        foreach ($boardOne as $rowKey => $rows) {
            $this->viewLeftBoard($rowKey);
            $this->viewXLine($boardOne[$rowKey], $rowKey);
            
            echo '  ';
            
            $this->viewLeftBoard($rowKey);
            $this->viewXLine($boardTwo[$rowKey], $rowKey, $this->hideShipsOnTwoBoard);
            
            echo PHP_EOL;
        }
        
        $this->messagePanelBoard();
        $this->inputMessage();
    }

    public function boardAndShadow(GameBoard $boardOne): void
    {
        $this->clearDisplay();

        $board = $boardOne->get();
        $shadow = $boardOne->getShadowMap();

        $this->messagePanel($this->message);

        foreach ($board as $rowKey => $rows) {
            $this->viewLeftBoard($rowKey);
            $this->viewXLine($board[$rowKey], $rowKey);

            echo '  ';

            $this->viewLeftBoard($rowKey);
            $this->viewXLine($shadow[$rowKey], $rowKey);

            echo PHP_EOL;
        }
        $this->messagePanelBoard();
        $this->inputMessage();
    }

    /**
     * Общий вывод меню
     */
    public function mainMenu(array $content = []): void
    {
        $this->clearDisplay();
        
        $this->messagePanel($this->message);
        
        $this->menuSpace($content);
    }
    
    /**
     * Панель основного вывода
     */
    private function menuSpace(array $content): void
    {
        foreach ($content as $item) {
            //echo $item;
            $this->prepareMenuLine($item);
        }
        
        //Вычитаем из высоты панели количество выведенных строк контента
        $spaceHeight = 11 - count($content);
        
        for ($i = 0; $i < $spaceHeight; $i++) {
            echo '*';
            echo PHP_EOL;
        }
        $this->messagePanelBoard();
    }

    /**
     * Подготовка опций игрового меню
     */
    public function prepareMenuOptions(array $menu): array
    {
        $options = [];
        
        foreach ($menu as $key => $option) {
            $options[] = "[{$key}] $option";
        }
        
        return $options;
    }

    /**
     * Подготовка одной строки к добавлению в меню
     */
    private function prepareMenuLine(string $text)
    {
        $textLength = mb_strlen($text);
        
        if ($textLength > self::MAX_CHAR_IN_ONE_LINE) {
            throw new Exception('Number of characters per line, exceeds maximum length of ' . self::MAX_CHAR_IN_ONE_LINE . ' characters.');
        }
        
        $freeSpace = self::MAX_CHAR_IN_ONE_LINE - $textLength;
        $balance = $freeSpace % 2;
        $leftSpaceLength = ($freeSpace - $balance) / 2;
        $rightSpaceLength = $leftSpaceLength + $balance;
        $left = str_repeat(' ', $leftSpaceLength);
        $right = str_repeat(' ', $rightSpaceLength);
        
        echo '* ' . $left . $text . $right . " *\n";
    }

    /**
     * Полная очистка дисплея перед выводом информации на экран
     */
    public function clearDisplay(): void
    {
        if ($this->debugOn) {
            return;
        }
        
        if ($this->getOS() === self::WIN_OS) {
            system('CLS');
        } else {
            system('clear');
        }
    }

    /**
     * Подготовка сообщения к выводу
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Сообщение для меню ввода
     */
    public function inputMessage(): void
    {
        echo 'Enter new ship coordinate: ';
    }

    /**
     * Панель информационных сообщений
     */
    private function messagePanel(string $message): void
    {
        $prepareMessage = $this->prepareMessage($message);

        $this->messagePanelBoard();
        $this->message($prepareMessage);
        $this->messagePanelBoard();
    }

    /**
     * Подготовка текста сообщения к добавлению на панель сообщений
     */
    private function prepareMessage(string $message): array
    {
        if (mb_strlen($message) >= self::MAX_MESSAGE_LENGTH) {
            throw new Exception('Message length exceeds ' . self::MAX_MESSAGE_LENGTH . ' characters');
        }
        
        $messageWords = explode(' ', $message);
        $newMessage = array_fill(0, self::MAX_LINES_IN_MESSAGE, '');
        
        $nextLineLength = 0;
        $strNum = 0;
        foreach ($messageWords as $word) {
            $nextLineLength += mb_strlen($word) + 1;
            if ($nextLineLength <= self::MAX_CHAR_IN_ONE_LINE) {
                $newMessage[$strNum] .= ' ';
            } else {
                $nextLineLength = mb_strlen($word);
                $strNum++;
            }
            $newMessage[$strNum] .= $word;
        }
        
        return $newMessage;
    }

    /**
     * Вывод подготовленного сообщения в панеле сообщений
     */
    private function message(array $message): void
    {
        if (empty($message[1])) {
            $message[1] = $message[0];
            $message[0] = '';
        }
        
        foreach ($message as $string) {
            echo self::MESSAGE_PANEL_BOARD_VIEW . ' ';
            echo str_pad($string, self::MAX_CHAR_IN_ONE_LINE, ' ', STR_PAD_BOTH);
            echo ' ' . self::MESSAGE_PANEL_BOARD_VIEW;
            echo PHP_EOL;
        }
    }

    /**
     * Вывод горизонтальной линии панели сообщения
     */
    private function messagePanelBoard(): void
    {
        for ($i = 0; $i < self::MESSAGE_PANEL_BOARD_LENGTH; $i++) {
            echo self::MESSAGE_PANEL_BOARD_VIEW;
        }
        echo PHP_EOL;
    }
    
    /**
     * Вывод линии игрового поля по X
     */
    private function viewXLine(array $arr, $rowKey, bool $shipHidden = false): void
    {
        foreach ($arr as $colKey => $col) {
            echo $this->viewTopBoard($rowKey, $colKey, $col, $shipHidden);
        }
    }
    
    /**
     * Конвертирование кода состояния игрового поля в символ представления
     */
    private function convertCellType(int $type, bool $shipHidden): string
    {
        if ($shipHidden) {
            switch ($type) {
                case (1):
                    return self::MISS_CELL;
                case (3):
                    return self::DESTROY_CELL;
                default:
                    return self::EMPTY_CELL;
            }
        } else {
            switch ($type) {
                case (0):
                    return self::EMPTY_CELL;
                case (1):
                    return self::MISS_CELL;
                case (2):
                    return self::SHIP_CELL;
                case (3):
                    return self::DESTROY_CELL;
                case (4):
                    return self::SHADOW_CELL;
            }
        }
    }
    
    /**
     * Вывод цифрового поля игровой доски
     */
    private function viewTopBoard($rowKey, $colKey, $col, bool $shipHidden): string
    {
        if ($rowKey === self::ASCII_COMMERCIAL_AT) {
                return $colKey . ' ';
        }
        
        return $this->convertCellType($col, $shipHidden) . ' ';
    }
    
    /**
     * Вывод буквенного поля игровой доски
     */
    private function viewLeftBoard($key): void
    {
        if ($key === self::ASCII_COMMERCIAL_AT) {
            echo ' ';
        } else {
            echo chr($key) . ' ';
        }
    }

    /**
     * Получить тип ОС
     */
    private function getOS(): string
    {
        return $_SERVER['OS'] ?? '';
    }
}

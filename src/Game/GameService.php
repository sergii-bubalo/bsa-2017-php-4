<?php

namespace BinaryStudioAcademy\Game;

use BinaryStudioAcademy\Game\Exceptions\EmptyException;
use BinaryStudioAcademy\Game\Exceptions\NotFoundException;

class GameService
{
    private $game;
    private $isComplete;
    private $message;

    public function __construct(Game $game)
    {
        $this->game = $game;
        $this->isComplete = false;
        $this->message = "";
    }

    public function where()
    {
        $position = $this->game->getPlayer()->getPosition();
        $this->message = "You're at {$position->getRoomName()}. You can go to: {$position->showAllRooms()}.";
    }

    public function status()
    {
        $this->message = "You're at {$this->game->getPlayer()->getPosition()->getRoomName()}. You have {$this->game->getPlayer()->coinsCount()} coins.";
    }

    public function help()
    {
        $this->message =
            "where - information about current position and available rooms." . PHP_EOL .
            "status - info about coins and current position." . PHP_EOL .
            "help - list of available commands." . PHP_EOL .
            "go <room> - go to the passed room." . PHP_EOL .
            "observe - search coins in the room." . PHP_EOL .
            "grab - take a coin." . PHP_EOL .
            "exit - quit this quest.";
    }

    public function go($room)
    {
        try {
            $this->game->getPlayer()->go($room);
            $this->where();
        } catch (NotFoundException $e) {
            $this->message = $e->getMessage();
        }
    }

    public function command($command, $params)
    {
        try {
            $reflectionMethod = new \ReflectionMethod(__CLASS__, $command);

            $reflectionMethod->invokeArgs($this, $params);
        } catch (\ReflectionException $e) {
            $this->message = "Unknown command: '{$command}'.";
        }
    }

    public function observe()
    {
        $this->message = "There {$this->game->getPlayer()->getPosition()->countArtifactItems('coin')} coin(s) here.";
    }

    public function grab()
    {
        try {
            $this->game->getPlayer()->grab();
            if ($this->game->getPlayer()->coinsCount() === Game::COINS_TO_WIN) {
                $this->isComplete = true;
                $this->message = "Good job. You've completed this quest. Bye!";
            } else {
                $this->message = "Congrats! Coin has been added to inventory.";
            }
        } catch (NotFoundException | EmptyException $e) {
            $this->message = $e->getMessage();
        }
    }

    public function exit()
    {
        $this->isComplete = true;
        $this->message = "Bye-bye!";
    }

    public function isComplete(): bool
    {
        return $this->isComplete;
    }

    public function getMessage(): string
    {
        return $this->message ?? "";
    }
}
<?php

namespace BinaryStudioAcademy\Game;


use BinaryStudioAcademy\Game\Contracts\Positions\Position;

class Player
{
    private $name;
    private $equipment;
    private $position;

    public function __construct(Position $position, string $name = 'Player')
    {
        $this->position = $position;
        $this->name = $name;
        $this->equipment = [];
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function go(string $position): void
    {
        $this->position = $this->position->getRoom($position);
    }

    public function grab(): void
    {
        $this->equipment["coin"][] = $this->position->popArtifactItem("coin");
    }

    public function coinsCount()
    {
        return count($this->equipment['coin'] ?? []);
    }
}
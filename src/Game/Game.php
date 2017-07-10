<?php

namespace BinaryStudioAcademy\Game;

use BinaryStudioAcademy\Game\Artifacts\Coin;
use BinaryStudioAcademy\Game\Contracts\Io\Reader;
use BinaryStudioAcademy\Game\Contracts\Io\Writer;
use BinaryStudioAcademy\Game\Rooms\Basement;
use BinaryStudioAcademy\Game\Rooms\Bedroom;
use BinaryStudioAcademy\Game\Rooms\Cabinet;
use BinaryStudioAcademy\Game\Rooms\Corridor;
use BinaryStudioAcademy\Game\Rooms\Hall;

class Game
{
    const COINS_TO_WIN = 5;
    private $player;
    private $service;

    public function __construct()
    {
        $hall = new Hall();
        $bedroom = new Bedroom();
        $cabinet = new Cabinet();
        $basement = new Basement();
        $corridor = new Corridor();

        $this->player = new Player($hall);
        $this->service = new GameService($this);

        $hall->addArtifactItem(new Coin());
        $bedroom->addArtifactItem(new Coin());
        $cabinet->addArtifactItem(new Coin());
        $basement->addArtifactItem(new Coin())->addArtifactItem(new Coin());

        $bedroom->addAvailableRoom($corridor);
        $cabinet->addAvailableRoom($corridor);
        $basement->addAvailableRoom($cabinet)->addAvailableRoom($hall);
        $hall->addAvailableRoom($basement)->addAvailableRoom($corridor);
        $corridor->addAvailableRoom($hall)->addAvailableRoom($cabinet)->addAvailableRoom($bedroom);
    }

    public function start(Reader $reader, Writer $writer): void
    {
        while(true) {
            $writer->write("Enter next command: ");

            $this->run($reader, $writer);

            if ($this->service->isComplete()) {
                break;
            }
        }
    }

    public function run(Reader $reader, Writer $writer)
    {
        $input = trim($reader->read());

        $params = explode(" ", $input);

        $command = array_shift($params);

        $this->service->command($command, $params);

        $writer->writeln($this->service->getMessage());
    }

    public function getPlayer() {
        return $this->player;
    }
}

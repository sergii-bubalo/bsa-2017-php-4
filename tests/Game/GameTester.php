<?php

namespace BinaryStudioAcademyTests\Game;

use BinaryStudioAcademy\Game\Contracts\Io\Reader;
use BinaryStudioAcademy\Game\Contracts\Io\Writer;
use BinaryStudioAcademy\Game\Game;

class GameTester
{
    private $game;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var Writer
     */
    private $writer;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function run(string $input)
    {
        $this->reader = new StringReader($input);
        $this->writer = new MemoryWriter;

        $this->game->run($this->reader, $this->writer);
    }

    public function getOutput(): string
    {
        rewind($this->writer->getStream());
        $output = stream_get_contents($this->writer->getStream());

        return $output;
    }
}

<?php

namespace BinaryStudioAcademy\Game\Rooms;

use BinaryStudioAcademy\Game\Artifacts\ArtifactItem;
use BinaryStudioAcademy\Game\Contracts\Positions\Position;
use BinaryStudioAcademy\Game\Exceptions\EmptyException;
use BinaryStudioAcademy\Game\Exceptions\NotFoundException;

abstract class Room implements Position
{
    protected $rooms = [];
    protected $artifacts = [];

    public function addAvailableRoom(Room $room)
    {
        $this->rooms[$room->getRoomName()][] = $room;

        return $this;
    }

    public function getRoom(string $roomName): string
    {
        if (!isset($this->rooms[$roomName])) {
            throw new NotFoundException("{$roomName} is unavailable");
        }

        return $this->rooms[$roomName];
    }

    public function showAllRooms(): string
    {
        return implode(", ", array_keys($this->rooms));
    }

    public function getRoomName(): string
    {
        return strtolower(str_replace(__NAMESPACE__ . "\\", "", get_called_class()));
    }

    public function addArtifact(ArtifactItem $artifactItem)
    {
        $this->artifacts[$artifactItem->getName()][] = $artifactItem;

        return $this;
    }

    public function popArtifactItem(string $artifactItemName): ArtifactItem
    {
        if (!isset($this->artifacts[$artifactItemName])) {
            throw new NotFoundException("This room is empty of {$artifactItemName}s... Sorry, Bro )");
        }
        if (empty($this->$this->artifacts[$artifactItemName])) {
            throw new EmptyException("This room is empty of {$artifactItemName}s... Sorry, Bro )");
        }

        return array_pop($this->artifacts[$artifactItemName]);
    }

    public function showAllArtifactsItems(): string
    {
        $artifactItems = [];
        foreach ($this->artifacts as $name => $artifactsArray) {
            $artifactItems[] = count($artifactsArray) . " {$name}";
        }

        return implode(",", $artifactItems);
    }

    public function countArtifactItems($name): string
    {
        return count($this->artifacts[$name] ?? []);
    }
}
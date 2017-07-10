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
        $this->rooms[$room->getRoomName()] = $room;

        return $this;
    }

    public function getRoom(string $roomName): Room
    {
        if (!isset($this->rooms[$roomName])) {
            throw new NotFoundException("Can not go to {$roomName}.");
        }

        return $this->rooms[$roomName];
    }

    public function showAllRooms(): string
    {
        return implode(", ", array_keys($this->rooms));
    }

    public function getRoomName(): string
    {
        $ns = __NAMESPACE__ . "\\";
        return strtolower(str_replace($ns, "", get_called_class()));
    }

    public function addArtifactItem(ArtifactItem $artifactItem)
    {
        $this->artifacts[$artifactItem->getName()][] = $artifactItem;

        return $this;
    }

    public function popArtifactItem(string $artifactItemName): ArtifactItem
    {
        if (!isset($this->artifacts[$artifactItemName])) {
            throw new NotFoundException("There is no {$artifactItemName}s left here. Type 'where' to go to another location.");
        }
        if (empty($this->artifacts[$artifactItemName])) {
            throw new EmptyException("There is no {$artifactItemName}s left here. Type 'where' to go to another location.");
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
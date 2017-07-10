<?php

namespace BinaryStudioAcademy\Game\Contracts\Positions;

use BinaryStudioAcademy\Game\Artifacts\ArtifactItem;
use BinaryStudioAcademy\Game\Rooms\Room;

interface Position
{
    function getRoom(string $position): Room;
    function popArtifactItem(string $artifactItemName): ArtifactItem;
}
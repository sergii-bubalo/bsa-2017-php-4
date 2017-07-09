<?php

namespace BinaryStudioAcademy\Game\Contracts\Positions;

use BinaryStudioAcademy\Game\Artifacts\ArtifactItem;

interface Position
{
    function getRoom(string $position): string;
    function popArtifactItem(string $artifactItemName): ArtifactItem;
}
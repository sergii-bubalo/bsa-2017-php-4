<?php

namespace BinaryStudioAcademy\Game\Artifacts;

use BinaryStudioAcademy\Game\Contracts\Artifacts\Artifact;

abstract class ArtifactItem implements Artifact
{
    public function getName(): string
    {
        return strtolower(str_replace(__NAMESPACE__ . '\\', '', get_called_class()));
    }
}
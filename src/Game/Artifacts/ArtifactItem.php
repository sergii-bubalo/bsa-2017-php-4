<?php

namespace BinaryStudioAcademy\Game\Artifacts;

use BinaryStudioAcademy\Game\Contracts\Artifacts\Artifact;

abstract class ArtifactItem implements Artifact
{
    public function getName(): string
    {
        $ns = __NAMESPACE__ . '\\';
        return strtolower(str_replace($ns,'', get_called_class()));
    }
}
<?php

declare(strict_types=1);

namespace Mthole\OpenApiMerge\Merge;

use cebe\openapi\spec\Paths;
use cebe\openapi\spec\SecurityRequirement;
use cebe\openapi\spec\SecurityScheme;

class PathMerger implements PathMergerInterface
{
    private const MERGE_METHODS = [
        'get',
        'put',
        'post',
        'delete',
        'options',
        'head',
        'patch',
        'trace',
    ];

    public function mergePaths(Paths $existingPaths, Paths $newPaths, array $securityRequirements): Paths
    {
        $pathCopy = new Paths($existingPaths->getPaths());
        foreach ($newPaths->getPaths() as $pathName => $newPath) {
            $existingPath = $pathCopy->getPath($pathName);

            if ($existingPath === null) {
                foreach (self::MERGE_METHODS as $method) {
                    if ($newPath->{$method} !== null && $newPath->{$method}->security === null) {
                        $newPath->{$method}->security = $securityRequirements;
                    }
                }
                $pathCopy->addPath($pathName, $newPath);
                continue;
            }

            foreach (self::MERGE_METHODS as $method) {
                if ($existingPath->{$method} !== null) {
                    continue;
                }

                if ($newPath->{$method} === null) {
                    continue;
                }

                $newPath->{$method}->security = $securityRequirements;
                $existingPath->{$method} = $newPath->{$method};
            }
        }

        return $pathCopy;
    }
}

<?php

declare(strict_types=1);

namespace Mthole\OpenApiMerge\Merge;

use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Paths;
use cebe\openapi\spec\SecurityRequirement;
use cebe\openapi\spec\SecurityScheme;

interface PathMergerInterface
{
    /**
     * @param Paths<PathItem> $existingPaths
     * @param Paths<PathItem> $newPaths
     * @param SecurityRequirement[] $securityRequirements
     *
     * @return Paths<PathItem>
     */
    public function mergePaths(Paths $existingPaths, Paths $newPaths, array $securityRequirements): Paths;
}

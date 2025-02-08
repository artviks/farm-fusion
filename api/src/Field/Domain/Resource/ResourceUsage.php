<?php

namespace App\Field\Domain\Resource;

readonly class ResourceUsage
{
    public function __construct(
        public string $taskId,
        public string $resourceId,
        public int    $usedQuantity,
    ) {}
}
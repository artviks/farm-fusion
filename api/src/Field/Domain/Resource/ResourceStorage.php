<?php

namespace App\Field\Domain\Resource;

readonly class ResourceStorage
{
    public function __construct(
        public string $resourceId,
        public int    $addedQuantity,
        public string $addedAt,
    ) {}
}
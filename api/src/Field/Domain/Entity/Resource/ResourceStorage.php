<?php

namespace App\Field\Domain\Entity\Resource;

readonly class ResourceStorage
{
    public function __construct(
        public string $resourceId,
        public int    $addedQuantity,
        public string $addedAt,
    ) {}
}
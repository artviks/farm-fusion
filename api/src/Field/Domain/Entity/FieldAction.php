<?php

namespace App\Field\Domain\Entity;

use App\Field\Domain\Resource\ResourceUsage;

class FieldAction
{
    /** @var ResourceUsage[] */
    private array $resourceUsages = [];

    public function __construct(
        public readonly string $id,
        public readonly string $fieldId,
        public readonly string $type,
        public readonly string $completedAt,
        public readonly string $startedAt,
        public readonly ?string $notes,
    ) {}

    public function useResource(string $resourceId, int $usedQuantity): void
    {
        $this->resourceUsages[] = new ResourceUsage(
            taskId: $this->id,
            resourceId: $resourceId,
            usedQuantity: $usedQuantity,
        );
    }

    public function getResourceUsages(): array
    {
        return $this->resourceUsages;
    }
}
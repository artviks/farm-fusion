<?php

namespace App\Field\Domain\Entity;

use App\Common\Uuid;
use App\Field\Domain\Entity\Resource\ResourceUsage;
use DateTimeImmutable;
use DateTimeInterface;

class FieldAction
{
    /** @var ResourceUsage[] */
    private array $resourceUsages = [];

    public readonly DateTimeInterface $createdAt;

    private function __construct(
        public readonly Uuid $id,
        public readonly string $fieldId,
        public readonly string $type,
        public readonly ?DateTimeInterface $completedAt,
        public readonly ?string $notes,
    ) {
        $this->createdAt = new DateTimeImmutable();
    }

    public static function new(Field $field, string $type, ?DateTimeInterface $completedAt, ?string $notes): self
    {
        return new self(
            Uuid::generate(),
            $field->id,
            $type,
            $completedAt,
            $notes,
        );
    }


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
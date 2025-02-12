<?php

use App\Field\Domain\Entity\Field;

readonly class FieldDTO
{
    private function __construct(
        public string $id,
        public string $name,
        public string $size,
        public ?string $notes,
    ) {
    }

    public static function fromEntity(Field $field): self
    {
        return new self(
            $field->id,
            $field->name,
            $field->size,
            $field->notes,
        );
    }
}
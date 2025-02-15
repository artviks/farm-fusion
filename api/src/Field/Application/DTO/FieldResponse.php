<?php

namespace App\Field\Application\DTO;

use App\Field\Domain\Entity\Field;
use JsonSerializable;

readonly class FieldResponse implements JsonSerializable
{
    private function __construct(
        public string  $id,
        public string  $name,
        public string  $size,
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

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
<?php

namespace App\Request;

readonly class CreateFieldRequest
{
    private function __construct(
        public string $name,
        public int $area,
        public ?string $notes
    ) {
    }

    public static function fromPayload(array $data): self
    {
        return new self(
            name: $data['name'],
            area: $data['area'],
            notes: $data['notes'] ?? null
        );
    }
}
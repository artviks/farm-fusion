<?php

namespace App\Field\Application\UseCases\AddField;

readonly class AddFieldCommand
{
    private function __construct(
        public string $name,
        public int $size,
        public ?string $notes,
    ) {}

    public static function new(string $name, int $size, ?string $notes): self
    {
        return new self($name, $size, $notes);
    }
}
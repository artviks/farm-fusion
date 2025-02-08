<?php

namespace App\Field\Application\UseCases\AddField;

readonly class AddFieldRequest
{
    public function __construct(
        public string $name,
        public int $size,
        public ?string $notes,
    ) {}
}
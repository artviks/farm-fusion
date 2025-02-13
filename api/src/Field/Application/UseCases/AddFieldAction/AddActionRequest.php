<?php

namespace App\Field\Application\UseCases\AddFieldAction;

use DateTimeInterface;

readonly class AddActionRequest
{
    public function __construct(
        public string  $fieldId,
        public string  $type,
        public DateTimeInterface  $completedAt,
        public ?string $notes,
    ) {}
}
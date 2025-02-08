<?php

namespace App\Field\Domain\Resource;

readonly class Resource
{
    public function __construct(
        public string  $id,
        public string  $name,
        public string  $category,
        public string  $unitOfMeasure,
        public string  $manufacturer,
        public string  $composition,
        public ?string $notes,
    ) {}
}
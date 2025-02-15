<?php

namespace App\Field\Domain\Entity;

use App\Common\Uuid;

class Field
{
    /** @var Action[] */
    private array $actions = [];

    private function __construct(
        public readonly Uuid $id,
        public readonly string $name,
        public readonly int $size,
        public readonly ?string $notes,
    ) {
    }

    public static function new(string $name, int $size, ?string $notes): self
    {
        return new self(Uuid::generate(), $name, $size, $notes);
    }

     public static function create(string $id, string $name, int $size, string $notes): self
     {
         return new self(Uuid::fromString($id), $name, $size, $notes);
     }

    public function addAction(Action $task): void
    {
        $this->actions[] = $task;
    }

    public function getActions(): array
    {
        return $this->actions;
    }
}
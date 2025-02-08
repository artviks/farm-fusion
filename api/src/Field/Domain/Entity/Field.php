<?php

namespace App\Field\Domain\Entity;

use App\Common\Uuid;

class Field
{
    /** @var FieldAction[] */
    private array $tasks = [];

    private function __construct(
        public readonly Uuid $id,
        public readonly string $name,
        public readonly int $size,
        public readonly ?string $notes,
    ) {
    }

    public static function createNew(string $name, int $size, string $notes): self
    {
        return new self(Uuid::generate(), $name, $size, $notes);
    }

    // TODO: Add a method for existing field creation
    // public static function createExisting(Uuid $id, string $name, int $size, string $notes): self
    // {
    //     return new self($id, $name, $size, $notes);
    // }


    public function addTask(FieldAction $task): void
    {
        $this->tasks[] = $task;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }
}
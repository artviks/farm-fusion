<?php

namespace App\Field\Domain\Repository;

use App\Field\Domain\Entity\Action;

interface ActionRepositoryInterface
{
    public function add(Action $fieldAction): void;

    public function get(string $id): Action;

    public function update(Action $fieldAction): void;

    public function delete(string $id): void;
}
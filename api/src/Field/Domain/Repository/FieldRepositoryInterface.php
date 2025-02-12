<?php

namespace App\Field\Domain\Repository;

use App\Field\Domain\Entity\Field;

interface FieldRepositoryInterface
{
    public function add(Field $field): void;

    public function get(string $id): Field;

    public function update(Field $field): void;
}
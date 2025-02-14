<?php

namespace App\Field\Domain\Repository;

use App\Field\Domain\Entity\Action;

interface ActionRepositoryInterface
{
    public function add(Action $action): void;

    public function update(Action $action): void;
}
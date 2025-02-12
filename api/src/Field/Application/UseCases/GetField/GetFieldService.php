<?php

namespace App\Field\Application\UseCases\GetField;

use App\Field\Domain\Repository\FieldRepositoryInterface;
use FieldDTO;

readonly class GetFieldService
{
    public function __construct(
        private FieldRepositoryInterface $fieldRepository,
    ) {}

    public function execute(string $id): FieldDTO
    {
        $field = $this->fieldRepository->get($id);

        return FieldDTO::fromEntity($field);
    }
}
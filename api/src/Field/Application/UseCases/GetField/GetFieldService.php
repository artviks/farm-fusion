<?php

namespace App\Field\Application\UseCases\GetField;

use App\Field\Application\DTO\FieldResponse;
use App\Field\Domain\Repository\FieldRepositoryInterface;

readonly class GetFieldService
{
    public function __construct(
        private FieldRepositoryInterface $fieldRepository,
    ) {}

    public function execute(string $id): FieldResponse
    {
        $field = $this->fieldRepository->get($id);

        return FieldResponse::fromEntity($field);
    }
}
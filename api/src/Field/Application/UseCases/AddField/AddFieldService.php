<?php

namespace App\Field\Application\UseCases\AddField;

use App\Field\Application\DTO\FieldResponse;
use App\Field\Domain\Entity\Field;
use App\Field\Domain\Repository\FieldRepositoryInterface;

readonly class AddFieldService
{
    public function __construct(
        private FieldRepositoryInterface $fieldRepository,
    ) {}

    public function execute(AddFieldCommand $command): FieldResponse
    {
        $field = Field::new(
            $command->name,
            $command->size,
            $command->notes,
        );

        $this->fieldRepository->add($field);

        return FieldResponse::fromEntity($field);
    }
}
<?php

namespace App\Field\Application\UseCases\AddField;

use App\Field\Domain\Entity\Field;
use App\Field\Domain\FieldRepositoryInterface;

readonly class AddFieldService
{
    public function __construct(
        private FieldRepositoryInterface $fieldRepository,
    ) {}

    public function execute(AddFieldRequest $request): void
    {
        $field = Field::create(
            $request->name,
            $request->size,
            $request->notes,
        );

        $this->fieldRepository->add($field);
    }
}
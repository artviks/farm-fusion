<?php

namespace App\Service;

use App\Entity\Field;
use App\Repository\FieldRepository;
use App\Request\CreateFieldRequest;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

readonly class FieldService
{
    public function __construct(
        private FieldRepository $fieldRepository
    ) {
    }

    public function getFields(): array
    {
        return $this->fieldRepository->findAll();
    }

    public function getField(int $id): Field
    {
        return $this->fieldRepository->find($id);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createField(CreateFieldRequest $fieldRequest): Field
    {
        $field = new Field(
            name: $fieldRequest->name,
            area: $fieldRequest->area,
            notes: $fieldRequest->notes
        );

        $this->fieldRepository->save($field);

        return $field;
    }
}
<?php

namespace App\Field\Application\UseCases\AddFieldAction;

use App\Field\Domain\Entity\Action;
use App\Field\Domain\Repository\ActionRepositoryInterface;
use App\Field\Domain\Repository\FieldRepositoryInterface;

readonly class AddActionService
{
    public function __construct(
        private FieldRepositoryInterface  $fieldRepository,
        private ActionRepositoryInterface $actionRepository,
    ) {}

    public function execute(AddActionRequest $request): void
    {
        $field = $this->fieldRepository->get($request->fieldId);

        $action = Action::new(
            $field,
            $request->type,
            $request->completedAt,
            $request->notes,
        );

        $this->actionRepository->add($action);
    }
}
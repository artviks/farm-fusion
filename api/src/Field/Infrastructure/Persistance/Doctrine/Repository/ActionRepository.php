<?php

namespace App\Field\Infrastructure\Persistance\Doctrine\Repository;

use App\Field\Domain\Entity\Action;
use App\Field\Domain\Repository\ActionRepositoryInterface;
use App\Field\Infrastructure\Persistance\Doctrine\Entity\DoctrineAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Action>
 */
class ActionRepository extends ServiceEntityRepository implements ActionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineAction::class);
    }

    public function add(Action $fieldAction): void
    {
        // TODO: Implement add() method.
    }

    public function get(string $id): Action
    {
        // TODO: Implement get() method.
    }

    public function update(Action $fieldAction): void
    {
        // TODO: Implement update() method.
    }

    public function delete(string $id): void
    {
        // TODO: Implement delete() method.
    }
}

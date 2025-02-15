<?php

namespace App\Field\Infrastructure\Persistence\Doctrine\Repository;

use App\Field\Domain\Entity\Action;
use App\Field\Domain\Exception\ActionNotFoundException;
use App\Field\Domain\Repository\ActionRepositoryInterface;
use App\Field\Infrastructure\Persistence\Doctrine\Entity\DoctrineAction;
use App\Field\Infrastructure\Persistence\Doctrine\Entity\DoctrineField;
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

    public function add(Action $action): void
    {
        $this->getEntityManager()->persist(DoctrineAction::createFromAction($action));
        $this->getEntityManager()->flush();
    }

    public function update(Action $action): void
    {
        $doctrineAction = $this->find($action->id);

        if ($doctrineAction === null) {
            throw ActionNotFoundException::forId($action->id);
        }

        $doctrineAction
            ->setField(DoctrineField::createFromField($action->field))
            ->setType($action->type)
            ->setCompletedAt($action->completedAt)
            ->setNotes($action->notes);

        $this->getEntityManager()->flush();
    }
}

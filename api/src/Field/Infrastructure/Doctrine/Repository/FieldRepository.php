<?php

namespace App\Field\Infrastructure\Doctrine\Repository;

use App\Field\Domain\Entity\Field;
use App\Field\Domain\FieldRepositoryInterface;
use App\Field\Infrastructure\Doctrine\Entity\DoctrineField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DoctrineField>
 */
class FieldRepository extends ServiceEntityRepository implements FieldRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineField::class);
    }

    public function add(Field $field): void
    {
        $this->getEntityManager()->persist(DoctrineField::createFromField($field));
        $this->getEntityManager()->flush();
    }

    public function get(string $id): Field
    {
        $doctrineField = $this->find($id);

        if ($doctrineField === null) {
            // TODO: Create a custom exception
            throw new \RuntimeException('Field not found');
        }

        return $doctrineField->toField();
    }

    public function update(Field $field): void
    {
        // TODO: Implement update() method.
    }
}

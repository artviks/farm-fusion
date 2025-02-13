<?php

namespace App\Field\Infrastructure\Persistance\Doctrine\Repository;

use App\Field\Domain\Entity\Field;
use App\Field\Domain\Exception\FieldNotFoundException;
use App\Field\Domain\Repository\FieldRepositoryInterface;
use App\Field\Infrastructure\Persistance\Doctrine\Entity\DoctrineField;
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
        /** @var DoctrineField|null $doctrineField */
        $doctrineField = $this->find($id);

        if ($doctrineField === null) {
            throw FieldNotFoundException::forId($id);
        }

        return Field::create(
            $doctrineField->id(),
            $doctrineField->name(),
            $doctrineField->size(),
            $doctrineField->notes()
        );
    }

    public function update(Field $field): void
    {
        $doctrineField = $this->find($field->id);

        if ($doctrineField === null) {
            throw FieldNotFoundException::forId($field->id);
        }

        $doctrineField
            ->setName($field->name)
            ->setSize($field->size)
            ->setNotes($field->notes);

        $this->getEntityManager()->flush();
    }
}

<?php

namespace App\Field\Infrastructure\Doctrine\Entity;

use App\Field\Domain\Entity\Field;
use App\Field\Infrastructure\Doctrine\Repository\FieldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FieldRepository::class)]
class DoctrineField
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private int $size;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes;

    /**
     * @var Collection<int, Action>
     */
    #[ORM\OneToMany(targetEntity: Action::class, mappedBy: 'Field')]
    private Collection $actions;

    private function __construct(
        string $id,
        string $name,
        int $size,
        ?string $notes,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->size = $size;
        $this->notes = $notes;
        $this->actions = new ArrayCollection();
    }

    public static function createFromField(Field $field): self
    {
        return new self(
            $field->id,
            $field->name,
            $field->size,
            $field->notes,
        );
    }

    /**
     * @return Collection<int, Action>
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): static
    {
        if (!$this->actions->contains($action)) {
            $this->actions->add($action);
            $action->setField($this);
        }

        return $this;
    }

    public function removeAction(Action $action): static
    {
        if ($this->actions->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getField() === $this) {
                $action->setField(null);
            }
        }

        return $this;
    }
}

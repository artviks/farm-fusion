<?php

namespace App\Field\Infrastructure\Persistance\Doctrine\Entity;

use App\Field\Domain\Entity\Field;
use App\Field\Infrastructure\Persistance\Doctrine\Repository\FieldRepository;
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

    private function __construct() {
        $this->actions = new ArrayCollection();
    }

    public static function createFromField(Field $field): self
    {
        return (new self())
            ->setId($field->id)
            ->setName($field->name)
            ->setSize($field->size)
            ->setNotes($field->notes);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function notes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
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

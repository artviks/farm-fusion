<?php

namespace App\Entity;

use App\Repository\FieldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FieldRepository::class)]
class Field
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name;

    #[ORM\Column]
    private ?int $area;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes;

    /**
     * @var Collection<int, LandParcel>
     */
    #[ORM\ManyToMany(targetEntity: LandParcel::class, inversedBy: 'fields')]
    private Collection $landParcels;

    /**
     * @var Collection<int, FieldAction>
     */
    #[ORM\OneToMany(targetEntity: FieldAction::class, mappedBy: 'field')]
    private Collection $fieldActions;

    public function __construct(
        string $name,
        int $area,
        ?string $notes = null
    )
    {
        $this->name = $name;
        $this->area = $area;
        $this->notes = $notes;
        $this->landParcels = new ArrayCollection();
        $this->fieldActions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @return Collection<int, LandParcel>
     */
    public function getLandParcels(): Collection
    {
        return $this->landParcels;
    }

    public function addLandParcel(LandParcel $landParcel): static
    {
        if (!$this->landParcels->contains($landParcel)) {
            $this->landParcels->add($landParcel);
        }

        return $this;
    }

    public function removeLandParcel(LandParcel $landParcel): static
    {
        $this->landParcels->removeElement($landParcel);

        return $this;
    }

    /**
     * @return Collection<int, FieldAction>
     */
    public function getFieldActions(): Collection
    {
        return $this->fieldActions;
    }

    public function addFieldAction(FieldAction $fieldAction): static
    {
        if (!$this->fieldActions->contains($fieldAction)) {
            $this->fieldActions->add($fieldAction);
            $fieldAction->setField($this);
        }

        return $this;
    }

    public function removeFieldAction(FieldAction $fieldAction): static
    {
        if ($this->fieldActions->removeElement($fieldAction)) {
            // set the owning side to null (unless already changed)
            if ($fieldAction->getField() === $this) {
                $fieldAction->setField(null);
            }
        }

        return $this;
    }
}

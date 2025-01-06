<?php

namespace App\Entity;

use App\Repository\FieldActionRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FieldActionRepository::class)]
class FieldAction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $completedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\ManyToOne(inversedBy: 'fieldActions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Field $field = null;

    /**
     * @var Collection<int, ResourceUsage>
     */
    #[ORM\OneToMany(targetEntity: ResourceUsage::class, mappedBy: 'fieldAction')]
    private Collection $resourceUsages;

    public function __construct()
    {
        $this->resourceUsages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCompletedAt(): ?DateTimeInterface
    {
        return $this->completedAt;
    }

    public function setCompletedAt(DateTimeInterface $completedAt): static
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function getField(): ?Field
    {
        return $this->field;
    }

    public function setField(?Field $field): static
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return Collection<int, ResourceUsage>
     */
    public function getResourceUsages(): Collection
    {
        return $this->resourceUsages;
    }

    public function addResourceUsage(ResourceUsage $resourceUsage): static
    {
        if (!$this->resourceUsages->contains($resourceUsage)) {
            $this->resourceUsages->add($resourceUsage);
            $resourceUsage->setFieldAction($this);
        }

        return $this;
    }

    public function removeResourceUsage(ResourceUsage $resourceUsage): static
    {
        if ($this->resourceUsages->removeElement($resourceUsage)) {
            // set the owning side to null (unless already changed)
            if ($resourceUsage->getFieldAction() === $this) {
                $resourceUsage->setFieldAction(null);
            }
        }

        return $this;
    }
}

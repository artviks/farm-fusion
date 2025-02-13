<?php

namespace App\Field\Infrastructure\Persistance\Doctrine\Entity;

use App\Field\Infrastructure\Persistance\Doctrine\Repository\ActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class DoctrineAction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'actions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DoctrineField $Field = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $completedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    /**
     * @var Collection<int, ResourceUsage>
     */
    #[ORM\OneToMany(targetEntity: ResourceUsage::class, mappedBy: 'Action')]
    private Collection $resourceUsages;

    public function __construct()
    {
        $this->resourceUsages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getField(): ?DoctrineField
    {
        return $this->Field;
    }

    public function setField(?DoctrineField $Field): static
    {
        $this->Field = $Field;

        return $this;
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

    public function getCompletedAt(): ?\DateTimeInterface
    {
        return $this->completedAt;
    }

    public function setCompletedAt(\DateTimeInterface $completedAt): static
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): static
    {
        $this->startedAt = $startedAt;

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
            $resourceUsage->setAction($this);
        }

        return $this;
    }

    public function removeResourceUsage(ResourceUsage $resourceUsage): static
    {
        if ($this->resourceUsages->removeElement($resourceUsage)) {
            // set the owning side to null (unless already changed)
            if ($resourceUsage->getAction() === $this) {
                $resourceUsage->setAction(null);
            }
        }

        return $this;
    }
}

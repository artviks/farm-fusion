<?php

namespace App\Entity;

use App\Repository\ResourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResourceRepository::class)]
class Resource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $unitOfMeasure = null;

    #[ORM\Column(length: 255)]
    private ?string $manufacturer = null;

    #[ORM\Column(nullable: true)]
    private ?array $composition = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    /**
     * @var Collection<int, ResourceUsage>
     */
    #[ORM\OneToMany(targetEntity: ResourceUsage::class, mappedBy: 'resource')]
    private Collection $resourceUsages;

    /**
     * @var Collection<int, ResourceStorage>
     */
    #[ORM\OneToMany(targetEntity: ResourceStorage::class, mappedBy: 'resource')]
    private Collection $resourceStorages;

    public function __construct()
    {
        $this->resourceUsages = new ArrayCollection();
        $this->resourceStorages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getUnitOfMeasure(): ?string
    {
        return $this->unitOfMeasure;
    }

    public function setUnitOfMeasure(string $unitOfMeasure): static
    {
        $this->unitOfMeasure = $unitOfMeasure;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?string $manufacturer): static
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getComposition(): ?array
    {
        return $this->composition;
    }

    public function setComposition(?array $composition): static
    {
        $this->composition = $composition;

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
            $resourceUsage->setResource($this);
        }

        return $this;
    }

    public function removeResourceUsage(ResourceUsage $resourceUsage): static
    {
        if ($this->resourceUsages->removeElement($resourceUsage)) {
            // set the owning side to null (unless already changed)
            if ($resourceUsage->getResource() === $this) {
                $resourceUsage->setResource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ResourceStorage>
     */
    public function getResourceStorages(): Collection
    {
        return $this->resourceStorages;
    }

    public function addResourceStorage(ResourceStorage $resourceStorage): static
    {
        if (!$this->resourceStorages->contains($resourceStorage)) {
            $this->resourceStorages->add($resourceStorage);
            $resourceStorage->setResource($this);
        }

        return $this;
    }

    public function removeResourceStorage(ResourceStorage $resourceStorage): static
    {
        if ($this->resourceStorages->removeElement($resourceStorage)) {
            // set the owning side to null (unless already changed)
            if ($resourceStorage->getResource() === $this) {
                $resourceStorage->setResource(null);
            }
        }

        return $this;
    }
}

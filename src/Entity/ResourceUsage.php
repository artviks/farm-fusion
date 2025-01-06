<?php

namespace App\Entity;

use App\Repository\ResourceUsageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResourceUsageRepository::class)]
class ResourceUsage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'resourceUsages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Resource $resource = null;

    #[ORM\ManyToOne(inversedBy: 'resourceUsages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FieldAction $fieldAction = null;

    #[ORM\Column]
    private ?int $quantityUsed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function getFieldAction(): ?FieldAction
    {
        return $this->fieldAction;
    }

    public function setFieldAction(?FieldAction $fieldAction): static
    {
        $this->fieldAction = $fieldAction;

        return $this;
    }

    public function getQuantityUsed(): ?int
    {
        return $this->quantityUsed;
    }

    public function setQuantityUsed(int $quantityUsed): static
    {
        $this->quantityUsed = $quantityUsed;

        return $this;
    }
}

<?php

namespace App\Field\Infrastructure\Persistence\Doctrine\Entity;

use App\Field\Infrastructure\Persistence\Doctrine\Repository\ResourceUsageRepository;
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
    private ?DoctrineAction $Action = null;

    #[ORM\ManyToOne(inversedBy: 'resourceUsages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Resource $Resource = null;

    #[ORM\Column]
    private ?int $quatityUsed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAction(): ?DoctrineAction
    {
        return $this->Action;
    }

    public function setAction(?DoctrineAction $Action): static
    {
        $this->Action = $Action;

        return $this;
    }

    public function getResource(): ?Resource
    {
        return $this->Resource;
    }

    public function setResource(?Resource $Resource): static
    {
        $this->Resource = $Resource;

        return $this;
    }

    public function getQuatityUsed(): ?int
    {
        return $this->quatityUsed;
    }

    public function setQuatityUsed(int $quatityUsed): static
    {
        $this->quatityUsed = $quatityUsed;

        return $this;
    }
}

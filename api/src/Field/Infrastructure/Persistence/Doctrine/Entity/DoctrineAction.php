<?php

namespace App\Field\Infrastructure\Persistence\Doctrine\Entity;

use App\Field\Domain\Entity\Action;
use App\Field\Infrastructure\Persistence\Doctrine\Repository\ActionRepository;
use DateTimeInterface;
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
    private string $id;

    #[ORM\ManyToOne(inversedBy: 'actions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DoctrineField $Field;

    #[ORM\Column(length: 255)]
    private string $type;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $completedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    /**
     * @var Collection<int, ResourceUsage>
     */
    #[ORM\OneToMany(targetEntity: ResourceUsage::class, mappedBy: 'Action')]
    private Collection $resourceUsages;

    private function __construct() {
        $this->resourceUsages = new ArrayCollection();
    }

    public static function createFromAction(Action $action): self
    {
        return new self()
            ->setId($action->id)
            ->setField(DoctrineField::createFromField($action->field))
            ->setType($action->type)
            ->setCompletedAt($action->completedAt)
            ->setNotes($action->notes);
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

    public function field(): DoctrineField
    {
        return $this->Field;
    }

    public function setField(?DoctrineField $Field): static
    {
        $this->Field = $Field;

        return $this;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function completedAt(): ?DateTimeInterface
    {
        return $this->completedAt;
    }

    public function setCompletedAt(DateTimeInterface $completedAt): static
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    public function notes(): ?string
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
    public function resourceUsages(): Collection
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

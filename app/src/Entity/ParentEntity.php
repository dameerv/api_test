<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\AddParentDto;
use App\ApiResource\ChangeParentDto;
use App\ApiResource\ParentDto;
use App\Repository\ParentEntityRepository;
use App\State\AddParentProcessor;
use App\State\ChangeParentProcessor;
use App\State\ParentStateProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ParentEntityRepository::class)]
#[ORM\Table(name: 'parent')]
#[ApiResource(
    shortName: 'Parent',
    normalizationContext: [
        'groups' => ['read'],
        'jsonld_embed_context' => true,
    ],
    denormalizationContext: [
        'groups' => ['write'],
        'jsonld_embed_context' => true,
    ]
)]
#[Get(output: ParentDto::class, provider: ParentStateProvider::class)]
#[Post(input: AddParentDto::class, processor: AddParentProcessor::class)]
#[GetCollection(output: ParentDto::class, provider: ParentStateProvider::class)]
#[Patch(input: ChangeParentDto::class, processor: ChangeParentProcessor::class)]
#[Delete]
class ParentEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Child::class, orphanRemoval: true)]
    #[Groups(['read', 'write'])]
    private Collection $children;

    public function __construct()
    {
        $this->children = new ArrayCollection();
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

    /**
     * @return Collection<int, Child>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Child $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Child $child): static
    {
        if ($this->children->removeElement($child)) {
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }
}

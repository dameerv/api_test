<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\ChildRepresentationDto;
use App\Repository\ChildRepository;
use App\State\ChildStateProvider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ChildRepository::class)]
#[ApiResource(
    shortName: 'Child',
    normalizationContext: [
        'groups' => ['read'],
        'jsonld_embed_context' => true,
    ],
    denormalizationContext: [
        'groups' => ['write'],
        'jsonld_embed_context' => true,
    ]
)]
#[GetCollection(output: ChildRepresentationDto::class, provider: ChildStateProvider::class)]
#[Post]
#[Get(output: ChildRepresentationDto::class, provider: ChildStateProvider::class)]
#[Patch]
#[Delete]
class Child
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'children')]
    private ?ParentEntity $parent = null;

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

    public function getParent(): ?ParentEntity
    {
        return $this->parent;
    }

    public function setParent(?ParentEntity $parent): static
    {
        $this->parent = $parent;

        return $this;
    }
}

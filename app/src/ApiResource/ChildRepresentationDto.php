<?php

namespace App\ApiResource;

use Symfony\Component\Serializer\Attribute\Groups;

/**
 * Dto for Get and GetCollection representations
 */
class ChildRepresentationDto
{
    #[Groups('read')]
    public int $id;

    #[Groups('read')]
    public string $name;

    #[Groups('read')]
    public ParentDto $parent;
}

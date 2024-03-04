<?php

namespace App\ApiResource;

use Symfony\Component\Serializer\Attribute\Groups;

class ParentDto
{
    #[Groups(['read'])]
    public int $id;

    #[Groups(['read'])]
    public string $name;

    /** @var ChildDto[] */
    #[Groups(['read'])]
    public array $children;

    #[Groups(['read'])]
    public int $childCount;
}

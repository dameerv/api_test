<?php

namespace App\ApiResource;

use App\Entity\Child;
use Symfony\Component\Serializer\Attribute\Groups;

class AddParentDto
{
    #[Groups(['write'])]
    public string $name;

    /** @var Child[] */
    #[Groups(['write'])]
    public array $children;
}

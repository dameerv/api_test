<?php

namespace App\ApiResource;

use App\Entity\Child;
use Symfony\Component\Serializer\Attribute\Groups;

class ChangeParentDto
{
    #[Groups(['read', 'write'])]
    public ?string $name = null;

    /** @var Child[] */
    #[Groups(['read', 'write'])]
    public array $children;
}

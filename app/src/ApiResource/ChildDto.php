<?php

namespace App\ApiResource;

use Symfony\Component\Serializer\Attribute\Groups;

class ChildDto
{
    #[Groups(['read'])]
    public int $id;

    #[Groups(['read'])]
    public string $name;
}

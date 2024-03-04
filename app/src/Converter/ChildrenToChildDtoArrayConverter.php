<?php

namespace App\Converter;

use App\ApiResource\ChildDto;
use App\Entity\Child;
use Doctrine\Common\Collections\ArrayCollection;

class ChildrenToChildDtoArrayConverter
{
    /**
     * Convert Collection of Child to array of ChildDto.
     *
     * @param ArrayCollection<int, Child> $children
     *
     * @return ChildDto[]
     */
    public static function convert(iterable $children): array
    {
        $childrenDtos = [];
        foreach ($children as $child) {
            $childDto = new ChildDto();
            $childDto->id = $child->getId();
            $childDto->name = $child->getName();

            $childrenDtos[] = $childDto;
        }

        return $childrenDtos;
    }
}

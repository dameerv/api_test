<?php

namespace App\Converter;

use App\ApiResource\ChildRepresentationDto;
use App\Entity\Child;

class ChildrenToChildRepresentationDtoArrayConverter
{
    /**
     * Convert array of children to array of ChildRepresentationDto
     *
     * @param Child[] $children
     *
     * @return ChildRepresentationDto[]
     */
    public static function convert(array $children): array
    {
        $childrenDtos = [];
        foreach ($children as $child) {
            $childDto = new ChildRepresentationDto();
            $childDto->id = $child->getId();
            $childDto->name = $child->getName();
            $childDto->parent = ParentToParentDtoConverter::convert($child->getParent());

            $childrenDtos[] = $childDto;
        }

        return $childrenDtos;
    }
}

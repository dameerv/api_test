<?php

namespace App\Converter;

use App\ApiResource\ChildRepresentationDto;
use App\Entity\Child;

/**
 * Converting Child To ChildRepresentationDto
 */
class ChildToChildRepresentationDtoConverter
{
    public static function convert(Child $child)
    {
        $childRepresentionDto = new ChildRepresentationDto();
        $childRepresentionDto->id = $child->getId();
        $childRepresentionDto->name = $child->getName();
        $childRepresentionDto->parent = ParentToParentDtoConverter::convert($child->getParent());

        return $childRepresentionDto;
    }
}

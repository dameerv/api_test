<?php

namespace App\Converter;

use App\ApiResource\ParentDto;
use App\Entity\ParentEntity;

/**
 * Convert Parent to ParentDto
 */
class ParentToParentDtoConverter
{
    public static function convert(ParentEntity $parent): ParentDto
    {
        $parentDto = new ParentDto();

        $parentDto->id = $parent->getId();
        $parentDto->name = $parent->getName();
        $parentDto->childCount = $parent->getChildren()->count();
        $parentDto->children = ChildrenToChildDtoArrayConverter::convert($parent->getChildren());

        return $parentDto;
    }
}

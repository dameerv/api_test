<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\AddParentDto;
use App\ApiResource\ParentDto;
use App\Converter\ParentToParentDtoConverter;
use App\Entity\ParentEntity;
use Doctrine\ORM\EntityManagerInterface;

readonly class AddParentProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param AddParentDto $data
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): ParentDto {
        if (AddParentDto::class !== get_debug_type($data)) {
            throw new \TypeError(sprintf('Type of $data variable should be %s. %s is given', AddParentDto::class, get_debug_type($data)));
        }

        $parent = new ParentEntity();

        $parent->setName($data->name);
        $this->entityManager->persist($parent);

        $this->addParentToChildren($data, $parent);
        $this->entityManager->flush();

        return ParentToParentDtoConverter::convert($parent);
    }

    /**
     * Adding parent to child and persists it.
     */
    private function addParentToChildren(
        AddParentDto $parentDto,
        ParentEntity $parent
    ): void {
        foreach ($parentDto->children as $child) {
            $parent->addChild($child);
            $this->entityManager->persist($child);
        }
    }
}

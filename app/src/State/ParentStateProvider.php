<?php

namespace App\State;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Converter\ParentToParentDtoConverter;
use App\Entity\ParentEntity;
use App\Repository\ParentEntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ParentStateProvider implements ProviderInterface
{
    public function __construct(private readonly ParentEntityRepository $parentEntityRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            $parents = $this->parentEntityRepository->findAll();

            return $this->createParentDtoArray($parents);
        }

        $parent = $this->parentEntityRepository->find($uriVariables['id']);
        if (null === $parent) {
            throw new NotFoundHttpException();
        }

        return ParentToParentDtoConverter::convert($parent);
    }

    /**
     * @param ParentEntity[] $parents
     *
     * @return ParentEntity[]
     */
    private function createParentDtoArray(array $parents): array
    {
        $collection = [];

        foreach ($parents as $parent) {
            $parentDto = ParentToParentDtoConverter::convert($parent);
            $collection[] = $parentDto;
        }

        return $collection;
    }
}

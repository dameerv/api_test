<?php

namespace App\State;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Converter\ChildrenToChildRepresentationDtoArrayConverter;
use App\Converter\ChildToChildRepresentationDtoConverter;
use App\Repository\ChildRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChildStateProvider implements ProviderInterface
{
    public function __construct(private readonly ChildRepository $childRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            $children = $this->childRepository->findAll();

            return ChildrenToChildRepresentationDtoArrayConverter::convert($children);
        }

        $child = $this->childRepository->find($uriVariables['id']);
        if (null === $child) {
            throw new NotFoundHttpException();
        }

        return ChildToChildRepresentationDtoConverter::convert($child);
    }
}

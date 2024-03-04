<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\ChangeParentDto;
use App\ApiResource\ParentDto;
use App\Converter\ParentToParentDtoConverter;
use App\Entity\ParentEntity;
use App\Repository\ParentEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class ChangeParentProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ParentEntityRepository $parentRepository,
    ) {
    }

    /**
     * @param ChangeParentDto $data
     *
     * @return ParentEntity
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): ParentDto {
        if (ChangeParentDto::class !== get_debug_type($data)) {
            throw new \TypeError(sprintf('Type of $data variable should be %s. %s is given', ChangeParentDto::class, get_debug_type($data)));
        }

        if (!isset($uriVariables['id'])) {
            throw new NotFoundHttpException();
        }

        $parent = $this->parentRepository->find($uriVariables['id']);
        if (!empty($data->name)) {
            $parent->setName($data->name);
        }

        if (!empty($data->children)) {
            $this->changeParentToChildren($data, $parent);
        }

        $this->entityManager->flush();

        return ParentToParentDtoConverter::convert($parent);
    }

    /**
     * Adding child to parent.
     */
    private function changeParentToChildren(
        ChangeParentDto $parentDto,
        ParentEntity $parent
    ): void {
        foreach ($parent->getChildren() as $child) {
            $parent->removeChild($child);
        }

        foreach ($parentDto->children as $child) {
            $this->entityManager->persist($child);
            $parent->addChild($child);
        }
    }
}

<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Group\Group;
use App\Domain\Model\Group\GroupRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class GroupRepository implements GroupRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ObjectRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Group::class);
    }

    public function save(Group $group): void
    {
        $this->entityManager->persist($group);
        $this->entityManager->flush();
    }

    public function delete(Group $group): void
    {
        $this->entityManager->remove($group);
        $this->entityManager->flush();
    }

    /**
     * @param int $articleId
     * @return Group|null
     */
    public function findById(int $articleId): ?Group
    {
        return $this->repository->find($articleId);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}

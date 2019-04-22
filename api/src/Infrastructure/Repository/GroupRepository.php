<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Group\Group;
use App\Domain\Model\Group\GroupRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Group[]    findAll()
 */
final class GroupRepository implements GroupRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
    public function findGroupById(int $articleId): ?Group
    {
        return $this->find($articleId);
    }

    /**
     * @return array
     */
    public function findAllGroups(): array
    {
        return $this->findAll();
    }
}

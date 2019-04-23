<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Group\Group;
use App\Domain\Model\Group\GroupRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\EntityNotFoundException;

class GroupRepository extends ServiceEntityRepository implements GroupRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * GroupRepository constructor.
     * @param RegistryInterface $registry
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(RegistryInterface $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Group::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param Group $group
     */
    public function save(Group $group): void {
        $this->entityManager->persist($group);
        $this->entityManager->flush();
    }

    /**
     * @param Group $group
     */
    public function delete(Group $group): void {
        $this->entityManager->remove($group);
        $this->entityManager->flush();
    }

    /**
     * @param int $id
     * @return Group
     * @throws EntityNotFoundException
     */
    public function findById(int $id): Group
    {
        $group = $this->find($id);
        if (!$group) {
            throw new EntityNotFoundException('Invalid group id');
        }
        return $group;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return parent::findAll();
    }
}

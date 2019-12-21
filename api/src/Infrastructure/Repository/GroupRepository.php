<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Group;
use App\Domain\Model\GroupRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class GroupRepository
 * @package App\Infrastructure\Repository
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group[]    findAll()
 */
class GroupRepository extends ServiceEntityRepository implements GroupRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * GroupRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
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
        if (null === $group) {
            throw new EntityNotFoundException('invalid group id');
        }
        return $group;
    }

    /**
     * @return array
     */
    public function getAll(): array {
        return $this->findAll();
    }
}

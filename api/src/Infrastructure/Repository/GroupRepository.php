<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Group\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Group|null findById($id)
 */
class GroupRepository extends ServiceEntityRepository
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
}

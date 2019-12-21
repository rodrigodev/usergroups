<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Model\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package App\Infrastructure\Repository
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User[]    findAll()
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     */
    public function save(User $user): void {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param User $user
     */
    public function delete(User $user): void {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * @param int $id
     * @return User
     * @throws EntityNotFoundException
     */
    public function findById(int $id): User
    {
        $user = $this->find($id);
        if (!$user) {
            throw new EntityNotFoundException('invalid user id');
        }
        return $user;
    }

    /**
     * @return array
     */
    public function getAll(): array {
        return $this->findAll();
    }
}

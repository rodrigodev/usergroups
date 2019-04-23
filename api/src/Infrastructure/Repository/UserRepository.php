<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Domain\Model\User\UserRepositoryInterface;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(RegistryInterface $registry, EntityManagerInterface $entityManager)
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
            throw new EntityNotFoundException('Invalid user id');
        }
        return $user;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return parent::findAll();
    }
}

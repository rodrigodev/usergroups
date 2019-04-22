<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method User[]    findAll()
 */
class UserRepository implements UserRepositoryInterface
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
        $this->repository = $this->entityManager->getRepository(User::class);
    }

    public function save(User $user): void {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function delete(User $user): void {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * @param int $userId
     * @return User|null
     */
    public function findUserById(int $userId): ?User
    {
        return $this->repository->find($userId);
    }

    /**
     * @return array
     */
    public function findAllUsers(): array
    {
        return $this->repository->findAll();
    }
}

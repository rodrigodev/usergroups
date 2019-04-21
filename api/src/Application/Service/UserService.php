<?php

namespace App\Application\Service;

use App\Domain\Model\User\User;
use App\Infrastructure\Repository\UserRepository;

final class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function getUser(int $userId): ?User
    {
        return $this->userRepository->find($userId);
    }

    public function getAllUsers(): ?array
    {
        return $this->userRepository->findAll();
    }

    public function save(User $user): User
    {
        $this->userRepository->save($user);
        return $user;
    }

    public function addUser(string $name): User
    {
        $user = new User();
        $user->setName($name);
        $this->userRepository->save($user);
        return $user;
    }

    public function updateUser(int $userId, string $name): ?User
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            return null;
        }
        $user->setName($name);
        $this->userRepository->save($user);
        return $user;
    }

    public function deleteUser(int $userId): void
    {
        $user = $this->userRepository->find($userId);
        if ($user) {
            $this->userRepository->delete($user);
        }
    }
}
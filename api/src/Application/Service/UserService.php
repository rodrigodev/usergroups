<?php

namespace App\Application\Service;

use App\Application\DTO\User\UserAssembler;
use App\Application\DTO\User\UserDTO;
use App\Domain\Model\User\User;
use App\Domain\Model\User\UserRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;

final class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserAssembler
     */
    private $userAssembler;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserAssembler $userAssembler
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserAssembler $userAssembler

    ){
        $this->userRepository = $userRepository;
        $this->userAssembler = $userAssembler;
    }

    /**
     * @param int $userId
     * @return User|null
     * @throws EntityNotFoundException
     */
    public function getUser(int $userId): ?User
    {
        $user = $this->userRepository->findUserById($userId);
        if (!$user) {
            throw new EntityNotFoundException(sprintf('User with id %d not found!', $userId));
        }

        return $user;
    }

    /**
     * @return array|null
     */
    public function getAllUsers(): ?array
    {
        return $this->userRepository->findAllUsers();
    }

    /**
     * @param UserDTO $userDTO
     * @return User
     */
    public function addUser(UserDTO $userDTO): User
    {
        $user = $this->userAssembler->createUser($userDTO);
        $this->userRepository->save($user);

        return $user;
    }

    /**
     * @param int $userId
     * @param UserDTO $userDTO
     * @return User|null
     * @throws EntityNotFoundException
     */
    public function updateUser(int $userId, UserDTO $userDTO): ?User
    {
        $user = $this->userRepository->findUserById($userId);
        if (!$user) {
            throw new EntityNotFoundException(sprintf('User with id %d not found!', $userId));
        }
        $user = $this->userAssembler->updateUser($user, $userDTO);
        $this->userRepository->save($user);

        return $user;
    }

    /**
     * @param int $userId
     * @throws EntityNotFoundException
     */
    public function deleteUser(int $userId): void
    {
        $user = $this->userRepository->findUserById($userId);
        if (!$user) {
            throw new EntityNotFoundException(sprintf('User with id %d not found!', $userId));
        }
        $this->userRepository->delete($user);

    }
}
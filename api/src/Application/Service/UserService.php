<?php

namespace App\Application\Service;

use App\Application\DTO\User\UserAssembler;
use App\Application\DTO\User\UserDTO;
use App\Domain\Model\User;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;

final class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserAssembler
     */
    private $userAssembler;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserAssembler $userAssembler
     */
    public function __construct(
        UserRepository $userRepository,
        UserAssembler $userAssembler
    ){
        $this->userRepository = $userRepository;
        $this->userAssembler = $userAssembler;
    }

    /**
     * @param int $userId
     * @return User
     * @throws EntityNotFoundException
     */
    public function getUser(int $userId): User
    {
        return $this->userRepository->findById($userId);
    }

    /**
     * @return array|null
     */
    public function getAllUsers(): ?array
    {
        return $this->userRepository->findAll();
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
        $user = $this->userRepository->findById($userId);
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
        $user = $this->userRepository->findById($userId);
        $this->userRepository->delete($user);
    }

    public function save(User $user): void {
        $this->userRepository->save($user);
    }

    /**
     * @param string $username
     * @param string $password
     * @return User
     * @throws WrongUserOrPasswordException
     */
    public function auth(string $username, string $password): User
    {
        /**
         * @var User $user
         */
        $user = $this->userRepository->findOneBy(["username" => $username]);

        if (!password_verify($password . $user->getSalt(), $user->getPassword())) {
            throw new WrongUserOrPasswordException();
        }

        return $user;
    }
}
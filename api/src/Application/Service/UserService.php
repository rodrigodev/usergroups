<?php

namespace App\Application\Service;

use App\Application\Request\User\UserRequestHandler;
use App\Application\Request\User\UserRequest;
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
     * @var UserRequestHandler
     */
    private $userAssembler;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserRequestHandler $userAssembler
     */
    public function __construct(
        UserRepository $userRepository,
        UserRequestHandler $userAssembler
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
     * @param UserRequest $userDTO
     * @return User
     */
    public function addUser(UserRequest $userDTO): User
    {
        $user = $this->userAssembler->createUser($userDTO);
        $this->userRepository->save($user);

        return $user;
    }

    /**
     * @param int $userId
     * @param UserRequest $userDTO
     * @return User|null
     * @throws EntityNotFoundException
     */
    public function updateUser(int $userId, UserRequest $userDTO): ?User
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

        return $this->refreshToken($user);
    }

    /**
     * @param User $user
     * @return User
     */
    private function refreshToken(User $user): User
    {
        $token = bin2hex(openssl_random_pseudo_bytes(16));

        $user->setApiToken($token);
        $this->userRepository->save($user);

        return $user;
    }
}
<?php

namespace App\Application\Service;

use App\Application\Request\User\UserRequestHandler;
use App\Application\Request\User\UserRequest;
use App\Domain\Model\User;
use App\Domain\Model\UserRepositoryInterface;
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
    private $userRequestHandler;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserRequestHandler $userRequestHandler
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserRequestHandler $userRequestHandler
    ){
        $this->userRepository = $userRepository;
        $this->userRequestHandler = $userRequestHandler;
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
     * @param UserRequest $userRequest
     * @return User
     */
    public function addUser(UserRequest $userRequest): User
    {
        $user = $this->userRequestHandler->createUser($userRequest);
        $this->userRepository->save($user);

        return $user;
    }

    /**
     * @param int $userId
     * @param UserRequest $userRequest
     * @return User|null
     * @throws EntityNotFoundException
     */
    public function updateUser(int $userId, UserRequest $userRequest): ?User
    {
        $user = $this->userRepository->findById($userId);
        $user = $this->userRequestHandler->updateUser($user, $userRequest);
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
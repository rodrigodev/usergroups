<?php

namespace App\Application\Request\User;

use App\Domain\Model\User;

/**
 * Class UserAssembler
 * @package App\Application\Request
 */
class UserRequestHandler
{
    /**
     * @param UserRequest $userDTO
     * @param User|null $user
     * @return User
     */
    public function readDTO(UserRequest $userDTO, ?User $user = null): User
    {
        if (!$user) {
            $user = new User();
        }

        $user->setName($userDTO->getName());


        return $user;
    }

    /**
     * @param User $user
     * @param UserRequest $userDTO
     * @return User
     */
    public function updateUser(User $user, UserRequest $userDTO): User
    {
        return $this->readDTO($userDTO, $user);
    }

    /**
     * @param UserRequest $userDTO
     * @return User
     */
    public function createUser(UserRequest $userDTO): User
    {
        return $this->readDTO($userDTO);
    }

    /**
     * @param User $user
     * @return UserRequest
     */
    public function writeDTO(User $user): UserRequest
    {
        return new UserRequest(
            $user->getName(),
            $user->getUsername(),
            $user->getPassword()
        );
    }

}

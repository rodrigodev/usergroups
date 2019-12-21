<?php

namespace App\Application\DTO\User;

use App\Domain\Model\User;

/**
 * Class UserAssembler
 * @package App\Application\DTO
 */
class UserAssembler
{
    /**
     * @param UserDTO $userDTO
     * @param User|null $user
     * @return User
     */
    public function readDTO(UserDTO $userDTO, ?User $user = null): User
    {
        if (!$user) {
            $user = new User();
        }

        $user->setName($userDTO->getName());


        return $user;
    }

    /**
     * @param User $user
     * @param UserDTO $userDTO
     * @return User
     */
    public function updateUser(User $user, UserDTO $userDTO): User
    {
        return $this->readDTO($userDTO, $user);
    }

    /**
     * @param UserDTO $userDTO
     * @return User
     */
    public function createUser(UserDTO $userDTO): User
    {
        return $this->readDTO($userDTO);
    }

    /**
     * @param User $user
     * @return UserDTO
     */
    public function writeDTO(User $user): UserDTO
    {
        return new UserDTO(
            $user->getName(),
            $user->getUsername(),
            $user->getPassword()
        );
    }

}

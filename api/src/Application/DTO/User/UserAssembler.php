<?php

namespace App\Application\DTO\User;

use App\Domain\Model\User\User;

/**
 * Class UserAssembler
 * @package App\Application\DTO
 */
final class UserAssembler
{
    /**
     * @param UserDTO $UserDTO
     * @param User|null $User
     * @return User
     */
    public function readDTO(UserDTO $UserDTO, ?User $User = null): User
    {
        if (!$User) {
            $User = new User();
        }

        $User->setContent($UserDTO->getContent());
        $User->setTitle($UserDTO->getTitle());

        return $User;
    }

    /**
     * @param User $User
     * @param UserDTO $UserDTO
     * @return User
     */
    public function updateUser(User $User, UserDTO $UserDTO): User
    {
        return $this->readDTO($UserDTO, $User);
    }

    /**
     * @param UserDTO $UserDTO
     * @return User
     */
    public function createUser(UserDTO $UserDTO): User
    {
        return $this->readDTO($UserDTO);
    }

    /**
     * @param User $User
     * @return UserDTO
     */
    public function writeDTO(User $User)
    {
        return new UserDTO(
            $User->getTitle(),
            $User->getContent()
        );
    }

}

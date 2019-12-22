<?php

namespace App\Application\Request\User;

use App\Domain\Model\User;

/**
 * Class UserRequestHandler
 * @package App\Application\Request
 */
class UserRequestHandler
{
    /**
     * @param UserRequest $userRequest
     * @param User|null $user
     * @return User
     */
    public function fromRequest(UserRequest $userRequest, ?User $user = null): User
    {
        if (!$user) {
            $user = new User();
        }

        $user->setName($userRequest->getName());
        $user->setUsername($userRequest->getUsername());
        $user->setPassword($userRequest->getPassword());

        return $user;
    }

    /**
     * @param User $user
     * @param UserRequest $userRequest
     * @return User
     */
    public function updateUser(User $user, UserRequest $userRequest): User
    {
        return $this->fromRequest($userRequest, $user);
    }

    /**
     * @param UserRequest $userRequest
     * @return User
     */
    public function createUser(UserRequest $userRequest): User
    {
        return $this->fromRequest($userRequest);
    }

    /**
     * @param User $user
     * @return UserRequest
     */
    public function toRequest(User $user): UserRequest
    {
        return new UserRequest(
            $user->getName(),
            $user->getUsername(),
            $user->getPassword()
        );
    }

}

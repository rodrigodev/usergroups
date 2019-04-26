<?php

namespace App\Application\Service;

use Doctrine\ORM\EntityNotFoundException;

class MembershipService
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var GroupService
     */
    protected $groupService;

    public function __construct(UserService $userService, GroupService $groupService)
    {
        $this->userService = $userService;
        $this->groupService = $groupService;
    }

    /**
     * @param int $userId
     * @param int $groupId
     * @throws EntityNotFoundException
     */
    public function addUserToGroup(int $userId, int $groupId): void
    {
        $user = $this->userService->getUser($userId);
        $group = $this->groupService->getGroup($groupId);

        $group->addUser($user);


        $this->groupService->save($group);
    }

    /**
     * @param int $userId
     * @param int $groupId
     * @throws EntityNotFoundException
     */
    public function removeUserFromGroup(int $userId, int $groupId): void
    {
        $user = $this->userService->getUser($userId);
        $group = $this->groupService->getGroup($groupId);

        $group->removeUser($user);

        $this->groupService->save($group);
    }
}
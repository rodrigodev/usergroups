<?php

namespace App\Service;

class MembershipService
{
    protected $userService;
    protected $groupService;

    public function __construct(UserService $userService, GroupService $groupService)
    {
        $this->userService = $userService;
        $this->groupService = $groupService;
    }

    public function addUserToGroup(int $userId, int $groupId)
    {
        $user = $this->userService->getUser($userId);
        $group = $this->groupService->getGroup($groupId);

        $group->addUser($user);

        $this->groupService->save($group);
    }

    public function removeUserFromGroup(int $userId, int $groupId)
    {
        $user = $this->userService->getUser($userId);
        $group = $this->groupService->getGroup($groupId);

        $group->removeUser($user);

        $this->groupService->save($group);
    }
}
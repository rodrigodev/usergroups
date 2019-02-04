<?php

namespace App\Service;

use App\Entity\Group;
use App\Repository\GroupRepository;

final class GroupService
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository){
        $this->groupRepository = $groupRepository;
    }

    public function getGroup(int $groupId): ?Group
    {
        return $this->groupRepository->find($groupId);
    }

    public function getAllGroups(): ?array
    {
        return $this->groupRepository->findAll();
    }

    public function save(Group $group): Group
    {
        $this->groupRepository->save($group);
        return $group;
    }

    public function addGroup(string $name): Group
    {
        $group = new Group();
        $group->setName($name);
        $this->groupRepository->save($group);
        return $group;
    }

    public function updateGroup(int $groupId, string $name): ?Group
    {
        $group = $this->groupRepository->find($groupId);
        if (!$group) {
            return null;
        }
        $group->setName($name);
        $this->groupRepository->save($group);
        return $group;
    }

    public function deleteGroup(int $groupId): void
    {
        $group = $this->groupRepository->find($groupId);
        if ($group) {
            $this->groupRepository->delete($group);
        }
    }
}
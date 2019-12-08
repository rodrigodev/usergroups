<?php

namespace App\Application\DTO\Group;

use App\Domain\Model\Group;

/**
 * Class GroupAssembler
 * @package App\Application\DTO
 */
final class GroupAssembler
{

    /**
     * @param GroupDTO $groupDTO
     * @param Group|null $group
     * @return Group
     */
    public function readDTO(GroupDTO $groupDTO, ?Group $group = null): Group
    {
        if (!$group) {
            $group = new Group();
        }

        $group->setName($groupDTO->getName());

        return $group;
    }

    /**
     * @param Group $group
     * @param GroupDTO $groupDTO
     * @return Group
     */
    public function updateGroup(Group $group, GroupDTO $groupDTO): Group
    {
        return $this->readDTO($groupDTO, $group);
    }

    /**
     * @param GroupDTO $groupDTO
     * @return Group
     */
    public function createGroup(GroupDTO $groupDTO): Group
    {
        return $this->readDTO($groupDTO);
    }

    /**
     * @param Group $group
     * @return GroupDTO
     */
    public function writeDTO(Group $group): GroupDTO
    {
        return new GroupDTO(
            $group->getName()
        );
    }

}

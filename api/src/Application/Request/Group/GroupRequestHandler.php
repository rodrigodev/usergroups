<?php

namespace App\Application\Request\Group;

use App\Domain\Model\Group;

/**
 * Class GroupRequestHandler
 * @package App\Application\Request
 */
final class GroupRequestHandler
{

    /**
     * @param GroupRequest $groupRequest
     * @param Group|null $group
     * @return Group
     */
    public function fromRequest(GroupRequest $groupRequest, ?Group $group = null): Group
    {
        if (!$group) {
            $group = new Group();
        }

        $group->setName($groupRequest->getName());

        return $group;
    }

    /**
     * @param Group $group
     * @param GroupRequest $groupRequest
     * @return Group
     */
    public function updateGroup(Group $group, GroupRequest $groupRequest): Group
    {
        return $this->fromRequest($groupRequest, $group);
    }

    /**
     * @param GroupRequest $groupRequest
     * @return Group
     */
    public function createGroup(GroupRequest $groupRequest): Group
    {
        return $this->fromRequest($groupRequest);
    }

    /**
     * @param Group $group
     * @return GroupRequest
     */
    public function toRequest(Group $group): GroupRequest
    {
        return new GroupRequest(
            $group->getName()
        );
    }

}

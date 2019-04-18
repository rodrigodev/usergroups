<?php

namespace App\Application\DTO;

use App\Domain\Model\Group\Group;

/**
 * Class GroupAssembler
 * @package App\Application\DTO
 */
final class GroupAssembler
{

    /**
     * @param GroupDTO $GroupDTO
     * @param Group|null $Group
     * @return Group
     */
    public function readDTO(GroupDTO $GroupDTO, ?Group $Group = null): Group
    {
        if (!$Group) {
            $Group = new Group();
        }

        $Group->setContent($GroupDTO->getContent());
        $Group->setTitle($GroupDTO->getTitle());

        return $Group;
    }

    /**
     * @param Group $Group
     * @param GroupDTO $GroupDTO
     * @return Group
     */
    public function updateGroup(Group $Group, GroupDTO $GroupDTO): Group
    {
        return $this->readDTO($GroupDTO, $Group);
    }

    /**
     * @param GroupDTO $GroupDTO
     * @return Group
     */
    public function createGroup(GroupDTO $GroupDTO): Group
    {
        return $this->readDTO($GroupDTO);
    }

    /**
     * @param Group $Group
     * @return GroupDTO
     */
    public function writeDTO(Group $Group)
    {
        return new GroupDTO(
            $Group->getTitle(),
            $Group->getContent()
        );
    }

}

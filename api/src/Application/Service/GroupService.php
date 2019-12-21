<?php

namespace App\Application\Service;

use App\Application\Request\Group\GroupRequestHandler;
use App\Application\Request\Group\GroupRequest;
use App\Domain\Model\Group;
use App\Infrastructure\Repository\GroupRepository;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Class GroupService
 * @package App\Application\Service
 */
final class GroupService
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var GroupRequestHandler
     */
    private $groupAssembler;
    /**
     * GroupService constructor.
     * @param GroupRepository $groupRepository
     * @param GroupRequestHandler $groupAssembler
     */
    public function __construct(
        GroupRepository $groupRepository,
        GroupRequestHandler $groupAssembler
    ){
        $this->groupRepository = $groupRepository;
        $this->groupAssembler = $groupAssembler;
    }

    /**
     * @param int $groupId
     * @return Group
     * @throws EntityNotFoundException
     */
    public function getGroup(int $groupId): Group
    {
        return $this->groupRepository->findById($groupId);
    }

    /**
     * @return array|null
     */
    public function getAllGroups(): ?array
    {
        return $this->groupRepository->findAll();
    }

    /**
     * @param GroupRequest $groupDTO
     * @return Group
     */
    public function addGroup(GroupRequest $groupDTO): Group
    {
        $group = $this->groupAssembler->createGroup($groupDTO);
        $this->groupRepository->save($group);
        return $group;
    }

    /**
     * @param int $groupId
     * @param GroupRequest $groupDTO
     * @return Group|null
     * @throws EntityNotFoundException
     */
    public function updateGroup(int $groupId, GroupRequest $groupDTO): ?Group
    {
        $group = $this->groupRepository->findById($groupId);
        $group = $this->groupAssembler->updateGroup($group, $groupDTO);
        $this->groupRepository->save($group);

        return $group;
    }

    /**
     * @param int $groupId
     * @throws EntityNotFoundException
     */
    public function deleteGroup(int $groupId): void
    {
        $group = $this->groupRepository->findById($groupId);
        $this->groupRepository->delete($group);
    }

    /**
     * @param Group $group
     */
    public function save(Group $group): void {
        $this->groupRepository->save($group);
    }
}
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
    private $groupRequestHandler;
    /**
     * GroupService constructor.
     * @param GroupRepository $groupRepository
     * @param GroupRequestHandler $groupRequestHandler
     */
    public function __construct(
        GroupRepository $groupRepository,
        GroupRequestHandler $groupRequestHandler
    ){
        $this->groupRepository = $groupRepository;
        $this->groupRequestHandler = $groupRequestHandler;
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
     * @param GroupRequest $groupRequest
     * @return Group
     */
    public function addGroup(GroupRequest $groupRequest): Group
    {
        $group = $this->groupRequestHandler->createGroup($groupRequest);
        $this->groupRepository->save($group);
        return $group;
    }

    /**
     * @param int $groupId
     * @param GroupRequest $groupRequest
     * @return Group|null
     * @throws EntityNotFoundException
     */
    public function updateGroup(int $groupId, GroupRequest $groupRequest): ?Group
    {
        $group = $this->groupRepository->findById($groupId);
        $group = $this->groupRequestHandler->updateGroup($group, $groupRequest);
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
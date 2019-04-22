<?php

namespace App\Application\Service;

use App\Application\DTO\Group\GroupAssembler;
use App\Application\DTO\Group\GroupDTO;
use App\Domain\Model\Group\Group;
use App\Infrastructure\Repository\GroupRepository;
use Doctrine\ORM\EntityNotFoundException;

final class GroupService
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var GroupAssembler
     */
    private $groupAssembler;
    /**
     * GroupService constructor.
     * @param GroupRepository $groupRepository
     * @param GroupAssembler $groupAssembler
     */
    public function __construct(
        GroupRepository $groupRepository,
        GroupAssembler $groupAssembler
    ){
        $this->groupRepository = $groupRepository;
        $this->groupAssembler = $groupAssembler;
    }

    /**
     * @param int $groupId
     * @return object|null
     * @throws EntityNotFoundException
     */
    public function getGroup(int $groupId)
    {
        $group = $this->groupRepository->findById($groupId);
        if (!$group) {
            throw new EntityNotFoundException(sprintf('Group with id %d not found!', $groupId));
        }
        return $group;
    }

    /**
     * @return array|null
     */
    public function getAllGroups(): ?array
    {
        return $this->groupRepository->findAll();
    }

    /**
     * @param GroupDTO $groupDTO
     * @return Group
     */
    public function addGroup(GroupDTO $groupDTO): Group
    {
        $group = $this->groupAssembler->createGroup($groupDTO);
        $this->groupRepository->save($group);
        return $group;
    }

    /**
     * @param int $groupId
     * @param GroupDTO $groupDTO
     * @return Group|null
     * @throws EntityNotFoundException
     */
    public function updateGroup(int $groupId, GroupDTO $groupDTO): ?Group
    {
        $group = $this->groupRepository->findById($groupId);
        if (!$group) {
            throw new EntityNotFoundException(sprintf('Group with id %d not found!', $groupId));
        }
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
        if (!$group) {
            throw new EntityNotFoundException(sprintf('Group with id %d not found!', $groupId));
        }

        $this->groupRepository->delete($group);
    }
}
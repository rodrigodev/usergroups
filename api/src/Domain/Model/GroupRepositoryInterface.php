<?php


namespace App\Domain\Model;


/**
 * Interface GroupRepositoryInterface
 * @package App\Domain\Model\Group
 */
interface GroupRepositoryInterface
{
    /**
     * @param int $id
     * @return Group
     */
    public function findById(int $id) : Group;

    /**
     * @return array|Group[]
     */
    public function getAll() : array;

    /**
     * @param Group $group
     */
    public function save(Group $group): void;

    /**
     * @param Group $group
     */
    public function delete(Group $group): void;

}
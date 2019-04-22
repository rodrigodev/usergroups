<?php

namespace App\Domain\Model\Group;

/**
 * Interface ArticleRepositoryInterface
 * @package App\Domain\Model\Group
 */
interface GroupRepositoryInterface
{
    /**
     * @param int $articleId
     * @return Group
     */
    public function findGroupById(int $articleId): ?Group;

    /**
     * @return Group[]
     */
    public function findAllGroups(): array;

    /**
     * @param Group $article
     */
    public function save(Group $article): void;

    /**
     * @param Group $article
     */
    public function delete(Group $article): void;

}
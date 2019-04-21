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
    public function findById(int $articleId): ?Group;

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param Group $article
     */
    public function save(Group $article): void;

    /**
     * @param Group $article
     */
    public function delete(Group $article): void;

}
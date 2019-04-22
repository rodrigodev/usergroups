<?php


namespace App\Domain\Model\User;

/**
 * Interface UserRepositoryInterface
 * @package App\Domain\Model\User
 */
interface UserRepositoryInterface
{
    /**
     * @param int $articleId
     * @return User
     */
    public function findUserById(int $articleId): ?User;

    /**
     * @return array
     */
    public function findAllUsers(): array;

    /**
     * @param User $article
     */
    public function save(User $article): void;

    /**
     * @param User $article
     */
    public function delete(User $article): void;
}
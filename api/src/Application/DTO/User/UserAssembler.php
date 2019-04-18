<?php

<<<<<<< HEAD
namespace App\Application\DTO\User;

use App\Domain\Model\User\User;

/**
 * Class UserAssembler
 * @package App\Application\DTO
 */
final class UserAssembler
{
    /**
     * @param UserDTO $UserDTO
     * @param User|null $User
     * @return User
     */
    public function readDTO(UserDTO $UserDTO, ?User $User = null): User
    {
        if (!$User) {
            $User = new User();
        }

        $User->setContent($UserDTO->getContent());
        $User->setTitle($UserDTO->getTitle());

        return $User;
    }

    /**
     * @param User $User
     * @param UserDTO $UserDTO
     * @return User
     */
    public function updateUser(User $User, UserDTO $UserDTO): User
    {
        return $this->readDTO($UserDTO, $User);
    }

    /**
     * @param UserDTO $UserDTO
     * @return User
     */
    public function createUser(UserDTO $UserDTO): User
    {
        return $this->readDTO($UserDTO);
    }

    /**
     * @param User $User
     * @return UserDTO
     */
    public function writeDTO(User $User)
    {
        return new UserDTO(
            $User->getTitle(),
            $User->getContent()
=======

namespace App\Application\DTO;


use App\Domain\Model\Article\Article;

/**
 * Class ArticleAssembler
 * @package App\Application\DTO
 */
final class ArticleAssembler
{

    /**
     * @param ArticleDTO $articleDTO
     * @param Article|null $article
     * @return Article
     */
    public function readDTO(ArticleDTO $articleDTO, ?Article $article = null): Article
    {
        if (!$article) {
            $article = new Article();
        }

        $article->setContent($articleDTO->getContent());
        $article->setTitle($articleDTO->getTitle());

        return $article;
    }

    /**
     * @param Article $article
     * @param ArticleDTO $articleDTO
     * @return Article
     */
    public function updateArticle(Article $article, ArticleDTO $articleDTO): Article
    {
        return $this->readDTO($articleDTO, $article);
    }

    /**
     * @param ArticleDTO $articleDTO
     * @return Article
     */
    public function createArticle(ArticleDTO $articleDTO): Article
    {
        return $this->readDTO($articleDTO);
    }

    /**
     * @param Article $article
     * @return ArticleDTO
     */
    public function writeDTO(Article $article)
    {
        return new ArticleDTO(
            $article->getTitle(),
            $article->getContent()
>>>>>>> 0acfa94b34dd9e657e58812dc5a6ec1a29e6347d
        );
    }

}

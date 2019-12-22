<?php

namespace App\Infrastructure\Http\Rest\Controller;

use App\Application\Request\User\UserRequest;
use App\Application\Service\UserService;
use App\Security\TokenAuthenticator;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityNotFoundException;
use Swagger\Annotations as Swagger;
use App\Domain\Model\User;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

final class UserController extends AbstractFOSRestController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Creates a User resource
     * @Rest\Post("/users", name="post_user")
     * @param UserRequest $userRequest
     * @return View
     * @Swagger\Parameter(
     *     name="name",
     *     in="body",
     *     type="string",
     *     description="The user name",
     *     @Swagger\Schema(ref=@Model(type=UserRequest::class))
     * )
     * @Swagger\Response(
     *     response=201,
     *     description="Created"
     * )
     * @Swagger\Tag(name="Users")
     *
     */
    public function postUser(UserRequest $userRequest): View
    {
        $user = $this->userService->addUser($userRequest);

        // In case our POST was a success we need to return a 201 HTTP CREATED response with the created object
        return View::create($user, Response::HTTP_CREATED);
    }

    /**
     * Retrieves an User resource
     * @Rest\Get("/users/{userId}")
     * @param int $userId
     * @return View
     * @throws EntityNotFoundException
     *
     * @Swagger\Response(
     *     response=200,
     *     description="Gets a user by id"
     * )
     * @Swagger\Tag(name="Users")
     */
    public function getUserById(int $userId): View
    {
        $user = $this->userService->getUser($userId);

        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($user, Response::HTTP_OK);
    }

    /**
     * Retrieves a collection of User resource
     * @Rest\Get("/users")
     * @Swagger\Response(
     *     response=200,
     *     description="Gets all users"
     * )
     * @Swagger\Tag(name="Users")
     */
    public function getUsers(): View
    {
        $users = $this->userService->getAllUsers();

        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of user object
        return View::create($users, Response::HTTP_OK);
    }

    /**
     * Replaces User resource
     * @Rest\Put("/users/{userId}")
     * @param int $userId
     * @param UserRequest $userRequest
     * @return View
     * @throws EntityNotFoundException
     * @Swagger\Response(
     *     response=200,
     *     description="Replaces a user resource"
     * )
     * @Swagger\Tag(name="Users")
     */
    public function putUser(int $userId, UserRequest $userRequest): View
    {
        $user = $this->userService->updateUser($userId, $userRequest);

        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return View::create($user, Response::HTTP_OK);
    }

    /**
     * Removes the User resource
     * @Rest\Delete("/users/{userId}")
     * @param int $userId
     * @return View
     * @throws EntityNotFoundException
     * @Swagger\Response(
     *     response=200,
     *     description="Remove a user by id"
     * )
     * @Swagger\Tag(name="Users")
     */
    public function deleteUser(int $userId): View
    {
        $this->userService->deleteUser($userId);

        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
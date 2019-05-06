<?php

namespace App\Infrastructure\Http\Rest\Controller;

use App\Application\DTO\User\UserDTO;
use App\Application\Service\UserService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityNotFoundException;
use Swagger\Annotations as Swagger;
use App\Domain\Model\User\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
     * Creates an User resource
     * @Rest\Post("/users", name="post_user")
     * @param UserDTO $userDTO
     * @return View
     * @Swagger\Parameter(
     *     name="name",
     *     in="body",
     *     type="string",
     *     description="The user name",
     *     @Swagger\Schema(ref=@Model(type=UserDTO::class))
     * )
     * @Swagger\Response(
     *     response=201,
     *     description="Created",
     *     @Swagger\Schema(ref=@Model(type=UserDTO::class))
     * )
     * @Swagger\Tag(name="Users")
     *
     */
    public function postUser(UserDTO $userDTO): View
    {
        $user = $this->userService->addUser($userDTO);

        // In case our POST was a success we need to return a 201 HTTP CREATED response with the created object
        return View::create($user, Response::HTTP_CREATED);
    }

    /**
     * Retrieves an User resource
     * @Rest\Get("/users/{userId}")
     * @param int $userId
     * @return View
     * @throws EntityNotFoundException
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
     * @param UserDTO $userDTO
     * @return View
     * @throws EntityNotFoundException
     */
    public function putUser(int $userId, UserDTO $userDTO): View
    {
        $user = $this->userService->updateUser($userId, $userDTO);

        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return View::create($user, Response::HTTP_OK);
    }

    /**
     * Removes the User resource
     * @Rest\Delete("/users/{userId}")
     * @param int $userId
     * @return View
     * @throws EntityNotFoundException
     */
    public function deleteUser(int $userId): View
    {
        $this->userService->deleteUser($userId);

        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
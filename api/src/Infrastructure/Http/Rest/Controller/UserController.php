<?php

namespace App\Infrastructure\Http\Rest\Controller;

use App\Infrastructure\Service\UserService;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

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
     * @Rest\Post("/users")
     */
    public function postUser(Request $request): View
    {
        $user = $this->userService->addUser($request->get('name'));

        // Todo: 400 response - Invalid Input
        // Todo: 404 response - Resource not found

        // In case our POST was a success we need to return a 201 HTTP CREATED response with the created object
        return View::create($user, Response::HTTP_CREATED);
    }

    /**
     * Retrieves an User resource
     * @Rest\Get("/users/{userId}")
     */
    public function getUserById(int $userId): View
    {
        $user = $this->userService->getUser($userId);

        // Todo: 404 response - Resource not found

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
     */
    public function putUser(int $userId, Request $request): View
    {
        $data = json_decode($request->getContent());
        $user = $this->userService->updateUser($userId, $data->name);

        // Todo: 400 response - Invalid Input
        // Todo: 404 response - Resource not found

        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return View::create($user, Response::HTTP_OK);
    }

    /**
     * Removes the User resource
     * @Rest\Delete("/users/{userId}")
     */
    public function deleteUser(int $userId): View
    {
        $this->userService->deleteUser($userId);

        // Todo: 404 response - Resource not found

        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
<?php

namespace App\Controller;

use App\Service\GroupService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class GroupController extends AbstractFOSRestController
{
    /**
     * @var GroupService
     */
    private $groupService;

    /**
     * GroupController constructor.
     * @param GroupService $groupService
     */
    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * Creates an Group resource
     * @Rest\Post("/groups")
     */
    public function postGroup(Request $request): View
    {
        $group = $this->groupService->addGroup($request->get('name'));

        // Todo: 400 response - Invalid Input
        // Todo: 404 response - Resource not found

        // In case our POST was a success we need to return a 201 HTTP CREATED response with the created object
        return View::create($group, Response::HTTP_CREATED);
    }

    /**
     * Retrieves an Group resource
     * @Rest\Get("/groups/{groupId}")
     */
    public function getGroup(int $groupId): View
    {
        $group = $this->groupService->getGroup($groupId);

        // Todo: 404 response - Resource not found

        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($group, Response::HTTP_OK);
    }

    /**
     * Retrieves a collection of Group resource
     * @Rest\Get("/groups")
     */
    public function getGroups(): View
    {
        $groups = $this->groupService->getAllGroups();

        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of group object
        return View::create($groups, Response::HTTP_OK);
    }

    /**
     * Replaces Group resource
     * @Rest\Put("/groups/{groupId}")
     */
    public function putGroup(int $groupId, Request $request): View
    {
        $group = $this->groupService->updateGroup($groupId, $request->get('name'), $request->get('content'));

        // Todo: 400 response - Invalid Input
        // Todo: 404 response - Resource not found

        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return View::create($group, Response::HTTP_OK);
    }

    /**
     * Removes the Group resource
     * @Rest\Delete("/groups/{groupId}")
     */
    public function deleteGroup(int $groupId): View
    {
        $this->groupService->deleteGroup($groupId);

        // Todo: 404 response - Resource not found

        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
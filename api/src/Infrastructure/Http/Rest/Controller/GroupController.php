<?php

namespace App\Infrastructure\Http\Rest\Controller;

use App\Application\Exceptions\ValidationException;
use App\Application\Service\GroupService;
use App\Domain\Model\Group;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as Swagger;
use App\Application\Request\Group\GroupRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class GroupController extends AbstractFOSRestController
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
     * Creates a Group resource
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return View
     * @throws ValidationException
     * @Rest\Post("/groups", name="create_group")
     * @Swagger\Parameter(
     *     name="create group request",
     *     in="body",
     *     description="A request to create a group",
     *     @Swagger\Schema(ref=@Model(type=GroupRequest::class))
     * )
     * @Swagger\Response(
     *     response=201,
     *     description="Created",
     * )
     * @Swagger\Tag(name="Groups")
     *
     */
    public function postGroup(Request $request, ValidatorInterface $validator): View
    {
        $group = $this->groupService->addGroup(GroupRequest::createFromRequest($request, $validator));

        // In case our POST was a success we need to return a 201 HTTP CREATED response with the created object
        return View::create($group, Response::HTTP_CREATED);
    }

    /**
     * Retrieves a Group resource
     * @param int $groupId
     * @Rest\Get("/groups/{groupId}")
     * @return View
     * @throws EntityNotFoundException
     * @Swagger\Response(
     *     response=200,
     *     description="Gets a group by id"
     * )
     * @Swagger\Tag(name="Groups")
     */
    public function getGroup(int $groupId): View
    {
        $group = $this->groupService->getGroup($groupId);

        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($group, Response::HTTP_OK);
    }

    /**
     * Retrieves a collection of Group resource
     * @Rest\Get("/groups")
     * @return View
     * @Swagger\Response(
     *     response=200,
     *     description="Gets all groups"
     * )
     * @Swagger\Tag(name="Groups")
     */
    public function getGroups(): View
    {
        $groups = $this->groupService->getAllGroups();

        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of group object
        return View::create($groups, Response::HTTP_OK);
    }

    /**
     * Replaces Group resource
     * @param int $groupId
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return View
     * @throws EntityNotFoundException
     * @throws ValidationException
     * @Rest\Put("/groups/{groupId}")
     * @Swagger\Response(
     *     response=200,
     *     description="Replaces a group resource"
     * )
     * @Swagger\Tag(name="Groups")
     */
    public function putGroup(int $groupId, Request $request, ValidatorInterface $validator): View
    {
        $group = $this->groupService->updateGroup($groupId, GroupRequest::createFromRequest($request, $validator));

        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return View::create($group, Response::HTTP_OK);
    }

    /**
     * Removes a Group resource
     * @Rest\Delete("/groups/{groupId}")
     * @throws EntityNotFoundException
     * @param int $groupId
     * @return View
     * @Swagger\Response(
     *     response=200,
     *     description="Removes a group by id"
     * )
     * @Swagger\Tag(name="Groups")
     */
    public function deleteGroup(int $groupId): View
    {
        $this->groupService->deleteGroup($groupId);

        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
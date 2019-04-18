<?php

namespace App\Infrastructure\Http\Rest\Controller;

use App\Infrastructure\Service\MembershipService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as Swagger;
use Nelmio\ApiDocBundle\Annotation\Model;

final class MembershipController extends AbstractFOSRestController
{
    /**
     * @var MembershipService
     */
    private $membershipService;

    /**
     * MembershipController constructor.
     * @param MembershipService $membershipService
     */
    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    /**
     * Add a User to a Group
     * @Rest\Post("/membership/join")
     *
     * @Swagger\Response(
     *     response=200,
     *     description="Returns nothing",
     * )
     * @Swagger\Parameter(
     *     name="user_id",
     *     in="query",
     *     type="string",
     *     description="The user id"
     * )
     *
     * @Swagger\Parameter(
     *     name="group_id",
     *     in="query",
     *     type="string",
     *     description="The group id"
     * )
     * @Swagger\Tag(name="Membership")
     */
    public function joinGroup(Request $request) {
        $userId = $request->get('user_id');
        $groupId = $request->get('group_id');

        $this->membershipService->addUserToGroup($userId, $groupId);

        return View::create([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove a User from a Group
     * @Rest\Post("/membership/quit")
     *
     * @Swagger\Response(
     *     response=200,
     *     description="Returns nothing",
     * )
     * @Swagger\Parameter(
     *     name="user_id",
     *     in="query",
     *     type="string",
     *     description="The user id"
     * )
     *
     * @Swagger\Parameter(
     *     name="group_id",
     *     in="query",
     *     type="string",
     *     description="The group id"
     * )
     * @Swagger\Tag(name="Membership")
     */
    public function quitGroup(Request $request) {
        $userId = $request->get('user_id');
        $groupId = $request->get('group_id');

        $this->membershipService->removeUserFromGroup($userId, $groupId);

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}

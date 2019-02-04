<?php

namespace App\Controller;

use App\Service\MembershipService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MembershipController extends AbstractFOSRestController
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
     * Adds a User to a Group
     * @Rest\Post("/membership/join")
     */
    public function joinGroup(Request $request) {
        $userId = $request->get('user_id');
        $groupId = $request->get('group_id');

        $this->membershipService->addUserToGroup($userId, $groupId);

        return View::create([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Removes a User rom a Group
     * @Rest\Post("/membership/quit")
     */
    public function quitGroup(Request $request) {
        $userId = $request->get('user_id');
        $groupId = $request->get('group_id');

        $this->membershipService->removeUserFromGroup($userId, $groupId);

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Infrastructure\Http\Rest\Controller;

use App\Application\Service\UserService;
use App\Application\Service\WrongUserOrPasswordException;
use App\Security\TokenAuthenticator;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Swagger\Annotations as Swagger;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Application\Request\LoginRequest;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class SecurityController
 * @package App\Infrastructure\Http\Web\Controller
 */
final class SecurityController extends AbstractController
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
     * Add a User to a Group
     * @Rest\Post("/authenticate", name="security_login")
     *
     * @Swagger\Response(
     *     response=200,
     *     description="Returns authentication token",
     * )
     *
     * @Swagger\Parameter(
     *     name="Login Request",
     *     in="body",
     *     description="The user and password",
     *     @Swagger\Schema(ref=@Model(type=LoginRequest::class))
     * )
     * @Swagger\Tag(name="Security")
     * @param TokenAuthenticator $authenticator
     * @param GuardAuthenticatorHandler $guardHandler
     * @param Request $request
     * @return View
     * @throws WrongUserOrPasswordException
     */
    public function login(TokenAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $user = $this->userService->auth($username, $password);

        $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main'
        );

        $response = [
            'success' => true,
            'token' => $user->getApiToken()
        ];

        return View::create($response, Response::HTTP_OK);
    }
}

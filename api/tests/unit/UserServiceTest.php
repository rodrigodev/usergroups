<?php


namespace App\Tests\Unit;


use App\Application\Request\User\UserRequestHandler;
use App\Application\Request\User\UserRequest;
use App\Application\Service\UserService;
use App\Domain\Model\User;
use App\Domain\Model\UserRepositoryInterface;
use App\Infrastructure\Http\Rest\Controller\UserController;
use App\Infrastructure\Repository\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class UserServiceTest extends TestCase
{
    public function testUserCreation() {
        $name = 'Dave';
        $username = 'dave_mustaine';
        $password = '123456';

        $user = new User();
        $user->setName($name);
        $user->setPassword($password);
        $user->setUsername($username);

        $userData = new UserRequest(
            $name,
            $username,
            $password
        );

        /**
         * @var UserRepositoryInterface $userRepository
         */
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('save');

        $userService = new UserService($userRepository, new UserRequestHandler());
        $resultUser = $userService->addUser($userData);

        $this->assertEquals('Dave', $resultUser->getName());
        $this->assertEquals('dave_mustaine', $resultUser->getUsername());
    }
}
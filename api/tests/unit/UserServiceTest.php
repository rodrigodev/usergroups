<?php


namespace App\Tests\Unit;


use App\Application\Request\User\UserRequestHandler;
use App\Application\Request\User\UserRequest;
use App\Application\Service\UserService;
use App\Domain\Model\User;
use App\Domain\Model\UserRepositoryInterface;
use App\Infrastructure\Repository\UserRepository;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

final class UserServiceTest extends TestCase
{
    public function testUserCreation() {
        $faker = Factory::create();

        $name = $faker->name;
        $username = $faker->userName;
        $password = $faker->password;

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

        $this->assertEquals($name, $resultUser->getName());
        $this->assertEquals($username, $resultUser->getUsername());
    }
}
<?php


namespace App\Tests\Unit;


use App\Application\DTO\User\UserAssembler;
use App\Application\DTO\User\UserDTO;
use App\Application\Service\UserService;
use App\Domain\Model\User;
use App\Domain\Model\UserRepositoryInterface;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

final class UserServiceTest extends TestCase
{
    public function testUserCreation() {
        $name = 'Dave';
        $username = 'dave_mustaine';
        $password = '123456';

        $user = new User();
        $user->setName('Dave');

        $userData = new UserDTO(
            $name,
            $username,
            $password
        );

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('save')
            ->with($user);

        //$userAssembler

        $userService = new UserService($userRepository, new UserAssembler());
        $resultUser = $userService->addUser($userData);

        $this->assertEquals('Dave', $resultUser->getName());
    }
}
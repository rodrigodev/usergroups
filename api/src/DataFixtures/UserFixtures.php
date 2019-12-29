<?php

namespace App\DataFixtures;

use App\Domain\Model\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName('Admin');
        $user->setUsername('admin');
        $user->setPassword('admin');

        $manager->persist($user);
        $manager->flush();
    }
}

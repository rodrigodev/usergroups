<?php


namespace App\DataFixtures;


use App\Domain\Model\Horse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Ramsey\Uuid\Uuid;

class HorseFixtures extends Fixture
{
    /**
     * @var array
     */
    public static $uuids = [
        'fb6f25b6-5fce-4a0d-83b5-b2b193b6c182',
        'a79d2ae3-f748-49ff-9754-e784978c2abf',
        'cdb863b8-e5cf-4825-a10f-30a6b5734a2b',
        '32c5692c-0025-4ee6-9145-c34eac1b2d04'
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        foreach (self::$uuids as $uuid) {
            $horse = new Horse(Uuid::fromString($uuid));
            $horse->setName($faker->lastName);
            $horse->setPicture($faker->imageUrl(640, 480, 'cats'));
            $manager->persist($horse);
        }

        $manager->flush();
    }
}
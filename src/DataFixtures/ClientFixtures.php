<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ClientFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $client = (new Client())
                ->setEmail($faker->email)
                ->setWeight($faker->randomFloat(1, 50, 120))
                ->setName($faker->name)
                ->setAge($faker->randomNumber(2))
                ->setNumberBeer($faker->randomNumber(2));

            $manager->persist($client);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}

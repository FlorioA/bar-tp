<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        
        $user = (new User())
            ->setEmail('adrien@email.fr')
            ->setRoles(['ROLE_VISITOR', 'ROLE_ADMIN']);

        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            '123'
        ));

        $client = (new Client())
            ->setEmail($user->getEmail())
            ->setWeight($faker->randomFloat(1, 50, 120))
            ->setName($faker->name)
            ->setAge($faker->randomNumber(2))
            ->setNumberBeer($faker->randomNumber(2));
        

        $manager->persist($client);
        $user->setClient($client);

        $manager->persist($user);

        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }
}

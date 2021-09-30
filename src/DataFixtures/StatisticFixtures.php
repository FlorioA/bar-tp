<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Beer;
use App\Entity\Client;
use App\Entity\Statistic;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class StatisticFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        
        $clients = $manager->getRepository(Client::class)->findAll();
        $beers = $manager->getRepository(Beer::class)->findAll();

        foreach ($clients as $client) {
            $beer = $beers[rand(0, (count($beers) - 1))];

            $categories = [];
            foreach ($beer->getCategories() as $category) {
                $categories[] = $category->getId();
            }

            $statistic = (new Statistic())
                ->setClient($client)
                ->setBeer($beer)
                ->setCategories($categories)
                ->setScore($faker->randomDigit + 1);

            $manager->persist($statistic);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}

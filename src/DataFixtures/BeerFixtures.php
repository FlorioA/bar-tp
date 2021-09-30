<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Beer;
use App\Entity\Category;
use App\Entity\Country;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class BeerFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $count = 20;

        $countries = $manager->getRepository(Country::class)->findAll();

        $catNormals = $manager->getRepository(Category::class)->findByTerm('normal');
        $catSpecials = $manager->getRepository(Category::class)->findByTerm('special');
        $nbSpecials = count($catSpecials);
        
        while($count > 0){
            shuffle($countries);
            shuffle($catNormals);
            shuffle($catSpecials);
            $beer = new Beer();
            $beer->setName($faker->word);
            $beer->setPublishedAt($faker->dateTime());
            $beer->setPrice($faker->randomFloat(2, 4, 30));
            $beer->setDescription($faker->text(rand(200, 500)));
            $beer->setCountry($countries[0]);
            $beer->addCategory($catNormals[0]);

            foreach( array_slice($catSpecials, 0, rand(1, $nbSpecials)) as $catSpecial){
                $beer->addCategory($catSpecial);
            }

            $count--;
            $manager->persist($beer);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}

<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Beer;
use App\Entity\Country;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    //     $faker = Factory::create('fr_FR');

    //     $categoryNames = ['blonde', 'brune', 'blanche', 'houblon', 'rose', 'menthe', 'grenadine', 'réglisse', 'marron', 'whisky', 'bio'];

    //     foreach ($categoryNames as $categoryName) {
    //         $category = (new Category())
    //             ->setName($categoryName)
    //             ->setDescription($faker->sentences(3, true))
    //             ->setTerm(in_array($categoryName, ['blonde', 'brune', 'blanche']) ? 'normal' : 'special');

    //         for ($i = 0; $i <= rand(1, 2); $i++) {
    //             $country = (new Country())
    //                 ->setName($faker->country);

    //             for ($j = 0; $j <= rand(1, 3); $j++) {
    //                 $beer = (new Beer())
    //                     ->setname($faker->word)
    //                     ->setPublishedAt(new \DateTime())
    //                     ->setDescription($faker->sentences(3, true))
    //                     ->setPrice($faker->randomFloat(2, 1, 20))
    //                     ->addCategory($category)
    //                     ->setCountry($country);
            
    //                 $manager->persist($beer);
    //                 $country->addBeer($beer);
    //             }
    
    //             $manager->persist($country);
    //         }

    //         $manager->persist($category);
    //     }

    //     $manager->flush();
    }
}

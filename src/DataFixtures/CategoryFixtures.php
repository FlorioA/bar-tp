<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $categoriesNormals = ['blonde', 'brune', 'blanche'];
        $categoriesSpecials = ['houblon', 'rose', 'menthe', 'grenadine', 'réglisse', 'marron', 'whisky', 'bio'];
        foreach($categoriesNormals as $normal){
            $category = new Category;
            $category->setName($normal);
            $category->setTerm('normal');
            $category->setDescription($faker->text());
            // terme de la catégorie  par défaut normal
            $manager->persist($category);
        }

        foreach($categoriesSpecials as $special){
            $category = new Category;
            $category->setName($special);
            $category->setTerm('special');
            $category->setDescription($faker->text());
            $manager->persist($category);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}

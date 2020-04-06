<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Article\Statut;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create();



        for ($i = 0 ; $i <= 50 ; $i++)
{       $article = new Article();
        $article->setTitle($faker->word())
        ->setContent($faker->text($maxNbChars = 200))
        ->setStatus($faker->numberBetween($min = 0, $max = 2))
        ->setTrending($faker->boolean($chanceOfGettingTrue = 70))
        ->setPublished($faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = 'Europe/Paris'))
        ->setCreated($faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = 'Europe/Paris'))
        ->setCategoryId($faker->numberBetween(Statut::NONPUBLIE, Statut::PUBLIE));    
        $manager->persist($article);
}

        for ($i = 0 ; $i <= 5 ; $i++)
{       $category = new Category();
        $category->setName($faker->word())
        ->setCreated($faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = 'Europe/Paris'));
        $manager->persist($category);
    
}  

        $manager->flush();
    }
}

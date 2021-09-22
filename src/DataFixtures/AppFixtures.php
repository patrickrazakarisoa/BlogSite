<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create();
        $users = [];

        for ($i=0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setEmail($faker->email);
            $user->setPassword($faker->password());
            $user->setCreatedAt(new \DateTime());
            $manager->persist($user);
            $users[] = $user;            
        }

        $categories = [];

        for ($i=0; $i < 5; $i++) {
            $category = new Category();
            $category->setTitle($faker->text(50));
            $category->setDescription($faker->text(250));
            $category->setImage($faker->imageUrl());
            $user->setEmail($faker->email);
            $manager->persist($category);
            $categories[] = $category;            
        }

        $articles = [];

        for ($i=0; $i < 20; $i++) {
            $article = new Article();
            $article->setTitle($faker->text(50));
            $article->setContent($faker->text(5000));
            $article->setImage($faker->imageUrl());
            $article->setCreatedAt( new \DateTime());
            $article->addCategory($categories[$faker->numberBetween(0,4)]);
            $article->setAuthor($users[$faker->numberBetween(0,9)]);
            $articles[] = $article;
            $manager->persist($article);
        }

        $manager->flush();
    }
}
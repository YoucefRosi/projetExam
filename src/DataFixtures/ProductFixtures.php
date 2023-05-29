<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Generate multiple random products
        for ($i = 0; $i < 30; $i++) {
            $product = new Product();
            $product->setName($faker->word);
            $product->setPrice($faker->randomFloat(2, 0, 1000));
            $product->setPicture($faker->imageUrl());
            $product->setDescription($faker->paragraph);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
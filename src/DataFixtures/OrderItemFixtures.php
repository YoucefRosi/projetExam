<?php

namespace App\DataFixtures;

use App\Entity\OrderItem;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OrderItemFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Retrieve existing orders and products
        $orders = $manager->getRepository(Order::class)->findAll();
        $products = $manager->getRepository(Product::class)->findAll();

        // Generate order items with random quantities
        foreach ($orders as $order) {
            $numItems = random_int(1, 5); // Random number of items per order

            for ($i = 0; $i < $numItems; $i++) {
                $orderItem = new OrderItem();
                $orderItem->setOrder($order);
                $orderItem->setProductId($faker->randomElement($products));
                $orderItem->setQuantity(random_int(1, 10));
                $manager->persist($orderItem);
            }
        }

        $manager->flush();
    }
}

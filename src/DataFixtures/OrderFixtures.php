<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Retrieve existing users
        $users = $manager->getRepository(User::class)->findAll();

        // Generate orders for users
        foreach ($users as $user) {
            $numOrders = random_int(1, 3); // Random number of orders per user

            for ($i = 0; $i < $numOrders; $i++) {
                $order = new Order();
                $order->setUser($user);
                $order->setCreateAt($faker->dateTimeThisYear);
                $order->setStatus($faker->randomElement(['Pending', 'In Progress', 'Completed']));
                $manager->persist($order);

                // Generate order items for each order
                $numItems = random_int(1, 5); // Random number of items per order

                for ($j = 0; $j < $numItems; $j++) {
                    $orderItem = new OrderItem();
                    $orderItem->setOrder($order);
                    // Set other properties of the order item (e.g., product, quantity) as per your entity design
                    $manager->persist($orderItem);
                }
            }
        }

        $manager->flush();
    }
}

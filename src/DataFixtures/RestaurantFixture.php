<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class RestaurantFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for($i=0; $i<20; $i++){
            $restaurant = new Restaurant();
            $restaurant
                ->setName($faker->words(3, true))
                ->setTransportation($faker->paragraphs(3, true))
                ->setPlace($faker->numberBetween(20,200))
                ->setAveragePrice($faker->numberBetween(15,500))
                ->setAddress($faker->address)
                ->setTelephone($faker->numberBetween(1600000000,1799999999))
                ->setStartAt($faker->DateTime('2009-04-29 20:38:49', 'Europe/Paris'))
                ->setCloseAt($faker->DateTime('2009-04-29 20:38:49', 'Europe/Paris'))
                ->setEvaluation($faker->numberBetween(0, count(Restaurant::EVALUATION)-1))
                ;
            $manager->persist($restaurant);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}

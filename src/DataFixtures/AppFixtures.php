<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Car;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager) 
    {

        for ($i = 0; $i < 50; $i++) 
        {
            $car = new Car();
            $car->setDescription($this->faker->words(15, true));
            $car->setMileage(rand(100000, 200000));
            $car->setPrice(rand(1000, 10000));

            $randomDate = $this->faker->dateTimeThisCentury();
            $car->setYearOfManufacture($randomDate);;

            $manager->persist($car);            
        }
         
        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Car;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;
    private UserPasswordHasherInterface $hasher; 
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->hasher = $hasher;
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

        for($i =0; $i < 5 ; $i++)
        {
            $user = new User();
            $user->setEmail($this->faker->email());
            $user->setRoles(["ROLE_USER"]);
            $user->setPlainPassword("password");
            $manager->persist($user);
            
        }
         
        $manager->flush();
    }
}

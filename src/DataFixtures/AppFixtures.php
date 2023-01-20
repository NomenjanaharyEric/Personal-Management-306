<?php

namespace App\DataFixtures;

use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // create 11 department
        for ($i=0; $i < 10; $i++) { 
            $department = new Department();
            $department->setName($this->faker->word())
            ->setLocation($this->faker->sentence(mt_rand(2,5)));

            $manager->persist($department);
        }

        $manager->flush();
    }
}

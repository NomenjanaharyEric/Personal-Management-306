<?php

namespace App\DataFixtures;

use App\Entity\Department;
use App\Entity\Employee;
use App\Entity\Service;
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
        
        // create 5 department
        for ($i=0; $i < 5; $i++) { 
            $department = new Department();
            $department
                ->setName($this->faker->word())
                ->setLocation($this->faker->sentence(mt_rand(2,5)));

            // create services
            for ($j=0; $j < mt_rand(1,6) ; $j++) { 
                $service = new Service();
                $service->setName($this->faker->word());
                $department->addService($service);

                // create employee
                for ($k=0; $k < mt_rand(3,12) ; $k++) { 
                    $employee = new Employee();
                    $employee
                        ->setMatricule($this->faker->numberBetween(1,999999))
                        ->setName($this->faker->name())
                        ->setLastname($this->faker->lastName())
                        ->setSexe(mt_rand(0,1))
                        ->setNationality($this->faker->country())
                        ->setPhone($this->faker->phoneNumber())
                        ->setCin($this->faker->numberBetween(10000000000,999999999))
                        ->setFamilyStatus(mt_rand(0,1))
                        ->setEmail($this->faker->email())
                        ->setTitle($this->faker->title());
                    $service->addEmployee($employee);
                    $manager->persist($employee);
                }

                $manager->persist($service);
            }

            $manager->persist($department);
        }

        $manager->flush();
    }
}

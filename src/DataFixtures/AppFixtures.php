<?php

namespace App\DataFixtures;

use App\Entity\Contract;
use App\Entity\Department;
use App\Entity\Employee;
use App\Entity\Job;
use App\Entity\Service;
use DateTimeImmutable;
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

                // create job for each service
                for ($l=0; $l < mt_rand(3,13) ; $l++) { 
                    $job = new Job();
                    $job->setTitle($this->faker->title())
                        ->setWorkHours(mt_rand(10, 576))
                        ->setBaseSalary($this->faker->numberBetween(200000, 6000000))
                        ->setDescription($this->faker->paragraph());

                    $service->addJob($job);
                    
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
                            ->setEmail($this->faker->email());

                            // Creating contract
                        $contract = new Contract();
                        $contract
                            ->setTitle(join(" ",$this->faker->words()))
                            ->setStartDate(DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 days', '+2 week')))
                            ->setFinishedDate(DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('+2 week', '+1 years')))
                            ->setType(mt_rand(0,1) ?  "CDD" :  "Stage")
                            ->setStatus("en cours");

                        $employee->addContract($contract);
                        
                        $job->addEmployee($employee);

                        $manager->persist($contract);
                        $manager->persist($employee);

                    }

                    $manager->persist($job); 
                }


                $manager->persist($service);
            }

            $manager->persist($department);
        }

        $manager->flush();
    }
}

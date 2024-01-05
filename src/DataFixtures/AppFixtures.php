<?php


namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\YourEntity;
use Faker\Factory;

class MyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $entity = new YourEntity();
            $entity->setProperty1($faker->word);
            $entity->setProperty2($faker->sentence);

            // Ajoutez d'autres propriétés et générez des données Faker selon vos besoins

            $manager->persist($entity);
        }

        $manager->flush();
    }
}

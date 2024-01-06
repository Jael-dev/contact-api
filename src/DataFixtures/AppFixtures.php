<?php

// AppFixtures.php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // Groups
        // $groups = [];
        // for ($i = 0; $i < 10; $i++) {
        //     $entity = new Group();
        //     $entity->setName($faker->word())
        //     ->setDescription($faker->sentence())
        //     ->setColor($faker->hexcolor())
        //     ->setFavourite(mt_rand(0, 1) == 1 ? true : false);

        //     $groups[] = $entity;
        //     $manager->persist($entity);
        // }

        // Contacts

        // $contacts = [];

        // for ($i = 0; $i < 10; $i++) {
        //     $entity = new Contact();
        //     $entity->setFirstName($faker->firstName);
        //     $entity->setLastName($faker->lastName);
        //     $entity->setEmail($faker->email);
        //     $entity->setColor($faker->hexcolor);
        //     $entity->setPhone($faker->phoneNumber);
        //     $entity->setBirthday($faker->dateTime);
        //     $entity->setFavourite($faker->boolean);
        //     $entity->setGroupId($faker->randomElement($groups));

        //     $contacts[] = $entity;
        //     $manager->persist($entity);
        // }

        // AdditionalFields

        // $AdditionalFields = [];

        // for ($i = 0; $i < 10; $i++) {
        //     $entity = new AdditionalField();
        //     $entity->setFieldName($faker->word);
        //     $entity->setFieldValue($faker->randomElement(['text', 'number', 'date', 'email', 'url', 'tel']));
        //     $entity->setContactId($faker->randomElement($contacts));

        //     $AdditionalFields[] = $entity;
        //     $manager->persist($entity);
        // }


       
        $manager->flush();
    }
}

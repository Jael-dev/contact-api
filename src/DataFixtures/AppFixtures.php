<?php

// AppFixtures.php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Group;
use App\Entity\Contact;
use App\Entity\AdditionalField;
use App\Entity\ContactHistory;
use App\Repository\ContactRepository;
use Faker\Factory;

class AppFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // Groups
        $groups = [];

        $contacts = $manager->getRepository(Contact::class)->findAll();

        echo '<pre>';
            print_r($contacts);
            echo '</pre>';

        for ($i = 0; $i < 10; $i++) {
            $entity = new Group();
            $entity->setName($faker->firstName)
                ->setDescription($faker->text)
                ->setColor($faker->hexcolor)
                ->setIsFavorite(mt_rand(0, 1) == 1 ? true : false);
        
            foreach ($contacts as $contact) {
                $entity->addContact($contact);
            }
        
            $groups[] = $entity;
            $manager->persist($entity);
        }

        // Contacts

        $contacts = [];

        for ($i = 0; $i < 10; $i++) {
            $entity = new Contact();
            $entity->setFirstName($faker->firstName);
            $entity->setLastName($faker->lastName);
            $entity->setEmail($faker->email);
            $entity->setPhoneNumber($faker->phoneNumber);
            $entity->setBirthdate($faker->firstName);
            $entity->setIsFavorite($faker->boolean);
            $entity->setGroupId($faker->randomElement($groups));

            $contacts[] = $entity;
            $manager->persist($entity);
        }

        // AdditionalFields

        $AdditionalFields = [];

        for ($i = 0; $i < 10; $i++) {
            $entity = new AdditionalField();
            $entity->setFieldName($faker->word);
            $entity->setFieldValue($faker->randomElement(['text', 'number', 'date', 'email', 'url', 'tel']));
            $entity->setContact($faker->randomElement($contacts));

            $AdditionalFields[] = $entity;
            $manager->persist($entity);
        }

        // ContactHistory

        $ContactHistory = [];

        for ($i = 0; $i < 10; $i++) {
            $entity = new ContactHistory();
            $entity->setOperationName($faker->word);
            $entity->setTimestamp($faker->dateTime);
            $entity->setContact($faker->randomElement($contacts));

            $ContactHistory[] = $entity;
            $manager->persist($entity);
        }
       
        $manager->flush();
    }
}

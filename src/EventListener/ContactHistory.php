<?php

namespace App\EventListener;

use App\Entity\Contact;
use App\Entity\ContactHistory;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class ContactHistoryListener implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
        ];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // On s'intéresse uniquement à l'entité Contact
        if ($entity instanceof Contact) {
            // On récupère les changements
            $changes = $args->getEntityChangeSet();

            // Si des changements ont été détectés
            if (!empty($changes)) {
                // Créer une nouvelle entrée dans l'historique pour chaque changement
                $entityManager = $args->getEntityManager();

                foreach ($changes as $property => $change) {
                    $contactHistory = new ContactHistory();
                    $contactHistory->setOperationName('Contact Updated ' . $property);
                    $contactHistory->setTimestamp(new \DateTime());
                    $contactHistory->setContact($entity);


                    $entityManager->persist($contactHistory);
                }

                $entityManager->flush();
            }
        }
    }
}

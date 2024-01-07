<?php

namespace App\Controller;

use App\Entity\ContactHistory;
use App\Entity\Contact;
use App\Repository\ContactHistoryRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Collection;

#[Route('/contacthis')]
class ContactHistoryController extends AbstractController
{
    #[Route('/', methods: ['GET'])]
    public function index(ContactHistoryRepository $contactHistoryRepository): Response
    {
        $contactHistories = $contactHistoryRepository->findAll();
        $data = [];

        foreach ($contactHistories as $contactHistory) {
            $data[] = $this->serializeContactHistory($contactHistory);
        }

        return $this->json($data);
    }

    #[Route('/', name: 'app_contact_history_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $data = json_decode($request->getContent(), true);

        $contactHistory = new ContactHistory();
        $contactHistory->setOperationName('Created on ');
        $contactHistory->setTimestamp(new \DateTime($data['timestamp']));
       

        $contact = $entityManager->getRepository(Contact::class)->findContactById($id);
        if (!$contact) {
            return $this->json(['message' => 'Contact not found'], 404);
        }

        $contactHistory->setContact($contact);

        $entityManager->persist($contactHistory);
        $entityManager->flush();

        $data = $this->serializeContactHistory($contactHistory);

        return $this->json($data, 201);
    }

    #[Route('/update', name: 'app_contact_history_new', methods: ['POST'])]
    public function update(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $data = json_decode($request->getContent(), true);

        $contactHistory = new ContactHistory();
        $contactHistory->setOperationName('Updated on ');
        $contactHistory->setTimestamp(new \DateTime($data['timestamp']));
       

        $contact = $entityManager->getRepository(Contact::class)->findContactById($id);
        if (!$contact) {
            return $this->json(['message' => 'Contact not found'], 404);
        }

        $contactHistory->setContact($contact);

        $entityManager->persist($contactHistory);
        $entityManager->flush();

        $data = $this->serializeContactHistory($contactHistory);

        return $this->json($data, 201);
    }

    #[Route('/delete', name: 'app_contact_history_new', methods: ['DELETE'])]


    // todo: delete contact history
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $contactHistory = $contactHistoryRepository->findContactHistoryById($id);

        if (!$contactHistory) {
            return $this->json(['message' => 'ContactHistory non trouvé'], 404);
        }


        $entityManager->persist($contactHistory);
        $entityManager->remove($contactHistory);
        $entityManager->flush();

        return $this->json(['message' => 'ContactHistory supprimé avec succès']);

    }

  


    // Add routes for editing and deleting contact histories 

    private function serializeContactHistory(ContactHistory $contactHistory): array
    {
        return [
            'id' => $contactHistory->getId(),
            'operationName' => $contactHistory->getOperationName(),
            'timestamp' => $contactHistory->getTimestamp()->format('Y-m-d H:i:s'),
            'contact' => [
                'id' => $contactHistory->getContact()->getId(),
                'firstName' => $contactHistory->getContact()->getFirstName(),
                'lastName' => $contactHistory->getContact()->getLastName(),
                
            ],
            'additionalFields' => $this->serializeAdditionalFields($contactHistory->getAdditionalFields()),
        ];
    }

    private function serializeAdditionalFields(Collection $additionalFields): array
    {
        $result = [];

        foreach ($additionalFields as $additionalField) {
            $result[] = [
                'id' => $additionalField->getId(),
                'fieldName' => $additionalField->getFieldName(),
                'fieldValue' => $additionalField->getFieldValue(),
            ];
        }

        return $result;
    }
}

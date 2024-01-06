<?php

namespace App\Controller;

use App\Entity\ContactHistory;
use App\Repository\ContactHistoryRepository;
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
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $contactHistory = new ContactHistory();
        $contactHistory->setOperationName($data['operationName']);
        $contactHistory->setTimestamp(new \DateTime($data['timestamp']));
        // Add more fields as needed

        // Assuming $data['contactId'] is the ID of the associated Contact
        $contact = $entityManager->getRepository(Contact::class)->find($data['contactId']);
        if (!$contact) {
            return $this->json(['message' => 'Contact not found'], 404);
        }

        $contactHistory->setContact($contact);

        $entityManager->persist($contactHistory);
        $entityManager->flush();

        $data = $this->serializeContactHistory($contactHistory);

        return $this->json($data, 201);
    }

    #[Route('/{id}', name: 'app_contact_history_show', methods: ['GET'])]
    public function show(int $id, ContactHistoryRepository $contactHistoryRepository): Response
    {
        $contactHistory = $contactHistoryRepository->find($id);

        if (!$contactHistory) {
            return $this->json(['message' => 'Contact history not found'], 404);
        }

        $data = $this->serializeContactHistory($contactHistory);

        return $this->json($data);
    }

    // Add routes for editing and deleting contact histories if needed

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
                // Add more fields as needed
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

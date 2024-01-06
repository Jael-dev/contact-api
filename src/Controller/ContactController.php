<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Collection;

#[Route('/contact')]
class ContactController extends AbstractController
{

// Get the list of contacts
    #[Route('/',  methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {

        $contacts = $contactRepository->findAll();
        $data = [];

        foreach ($contacts as $contact) {
            $data[] = $this->serializeContact($contact);
        }

        return $this->json($data);
        
    }

    // Create a new contact

    #[Route('/', name: 'app_contact_new', methods: ['POST'])]

    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $contact = new Contact();
        $contact->setFirstName($data['firstName']);
        $contact->setLastName($data['lastName']);
        $contact->setPhoneNumber($data['phoneNumber']);
        $contact->setEmail($data['email']);
        $contact->setPhoto($data['photo']);
        $contact->setBirthdate($data['birthdate']);
        $contact->setIsFavorite($data['isFavorite']);
        $contact->setGroupId($data['groupId']);
        $entityManager->persist($contact);
        $entityManager->flush();

        $data = $this->serializeContact($contact);

        return $this->json($data, 201);
    }


    // Get a contact

    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]

    public function show( int $id, ContactRepository $contactRepository, Request $request): Response
    {
        $contact = $contactRepository->findContactById($id);

        if (!$contact) {
            return $this->json(['message' => 'Contact non trouvé'], 404);
        }

        $data = $this->serializeContact($contact);

        return $this->json($data);
    }

    // Edit a contact

    #[Route('/{id}', name: 'app_contact_edit', methods: ['PUT'])]

    public function edit(Request $request,  ContactRepository $contactRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $contact = $contactRepository->findContactById($id);

        if (!$contact) {
            return $this->json(['message' => 'Contact non trouvé'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $contact->setFirstName($data['firstName']);
        $contact->setLastName($data['lastName']);
        $contact->setPhoneNumber($data['phoneNumber']);
        $contact->setEmail($data['email']);
        $contact->setPhoto($data['photo']);
        $contact->setBirthdate($data['birthdate']);
        $contact->setIsFavorite($data['isFavorite']);
        $contact->setGroupId($data['groupId']);

        $entityManager->persist($contact);
        $entityManager->flush();

        $data = $this->serializeContact($contact);

        return $this->json($data);
    }


   // Delete a contact

   #[Route('/{id}',  methods: ['DELETE'])]

    public function delete(ContactRepository $contactRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $contact = $contactRepository->findContactById($id);

        if (!$contact) {
            return $this->json(['message' => 'Contact non trouvé'], 404);
        }

        $entityManager->persist($contact);
        $entityManager->remove($contact);
        $entityManager->flush();

        return $this->json(['message' => 'Contact supprimé avec succès']);
    }

    // Serialize a contact

    private function serializeContact(Contact $contact): array
    {
        return [
            'id' => $contact->getId(),
            'firstName' => $contact->getFirstName(),
            'lastName' => $contact->getLastName(),
            'phoneNumber' => $contact->getPhoneNumber(),
            'email' => $contact->getEmail(),
            'photo' => $contact->getPhoto(),
            'birthdate' => $contact->getBirthdate(),
            'isFavorite' => $contact->isIsFavorite(),
            'groupId' => $contact->getGroupId() ? $contact->getGroupId()->getId() : null,
            'additionalFields' => $this->serializeAdditionalFields($contact->getAdditionalFields()),
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

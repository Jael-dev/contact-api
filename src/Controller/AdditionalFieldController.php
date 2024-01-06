<?php

namespace App\Controller;

use App\Entity\AdditionalField;
use App\Repository\AdditionalFieldRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/additional')]
class AdditionalFieldController extends AbstractController
{
    #[Route('/', methods: ['GET'])]
    public function index(AdditionalFieldRepository $additionalFieldRepository): Response
    {
        $additionalFields = $additionalFieldRepository->findAll();
        $data = [];

        foreach ($additionalFields as $additionalField) {
            $data[] = $this->serializeAdditionalField($additionalField);
        }

        return $this->json($data);
    }

    #[Route('/', name: 'app_additional_field_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $additionalField = new AdditionalField();
        $additionalField->setFieldName($data['fieldName']);
        $additionalField->setFieldValue($data['fieldValue']);
       

        $entityManager->persist($additionalField);
        $entityManager->flush();

        $data = $this->serializeAdditionalField($additionalField);

        return $this->json($data, 201);
    }

    #[Route('/{id}', name: 'app_additional_field_show', methods: ['GET'])]
    public function show(int $id, AdditionalFieldRepository $additionalFieldRepository): Response
    {
        $additionalField = $additionalFieldRepository->find($id);

        if (!$additionalField) {
            return $this->json(['message' => 'Champ additionnel non trouvé'], 404);
        }

        $data = $this->serializeAdditionalField($additionalField);

        return $this->json($data);
    }

    #[Route('/{id}', name: 'app_additional_field_edit', methods: ['PUT'])]

    public function edit(int $id, Request $request, EntityManagerInterface $entityManager, AdditionalFieldRepository $additionalFieldRepository): Response
    {
        $additionalField = $additionalFieldRepository->find($id);

        if (!$additionalField) {
            return $this->json(['message' => 'Champ additionnel non trouvé'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $additionalField->setFieldName($data['fieldName']);
        $additionalField->setFieldValue($data['fieldValue']);
       

        $entityManager->flush();

        $data = $this->serializeAdditionalField($additionalField);

        return $this->json($data);
    }

    #[Route('/{id}', name: 'app_additional_field_delete', methods: ['DELETE'])]

    public function delete(int $id, EntityManagerInterface $entityManager, AdditionalFieldRepository $additionalFieldRepository): Response
    {
        $additionalField = $additionalFieldRepository->find($id);

        if (!$additionalField) {
            return $this->json(['message' => 'Champ additionnel non trouvé'], 404);
        }

        $entityManager->remove($additionalField);
        $entityManager->flush();

        return $this->json(['message' => 'Champ additionnel supprimé']);
    }   


    private function serializeAdditionalField(AdditionalField $additionalField): array
    {
        return [
            'id' => $additionalField->getId(),
            'fieldName' => $additionalField->getFieldName(),
            'fieldValue' => $additionalField->getFieldValue(),
        ];
    }
}

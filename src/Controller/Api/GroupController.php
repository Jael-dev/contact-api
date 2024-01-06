<?php

namespace App\Controller\Api;

use App\Entity\Group;
use App\Repository\GroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/groups")
 */
class GroupController extends AbstractController
{
    private GroupRepository $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $groups = $this->groupRepository->findAll();
        $data = [];

        foreach ($groups as $group) {
            $data[] = $this->serializeGroup($group);
        }

        return $this->json($data);
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $group = $this->groupRepository->find($id);

        if (!$group) {
            return $this->json(['message' => 'Groupe non trouvé'], 404);
        }

        $data = $this->serializeGroup($group);

        return $this->json($data);
    }

    /**
     * @Route("/", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $group = new Group();
        $group->setName($data['name']);
        $group->setDescription($data['description']);
        $group->setColor($data['color']);
        $group->setIsFavorite($data['isFavorite']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($group);
        $entityManager->flush();

        $data = $this->serializeGroup($group);

        return $this->json($data, 201);
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $group = $this->groupRepository->find($id);

        if (!$group) {
            return $this->json(['message' => 'Groupe non trouvé'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $group->setName($data['name']);
        $group->setDescription($data['description']);
        $group->setColor($data['color']);
        $group->setIsFavorite($data['isFavorite']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $data = $this->serializeGroup($group);

        return $this->json($data);
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $group = $this->groupRepository->find($id);

        if (!$group) {
            return $this->json(['message' => 'Groupe non trouvé'], 404);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($group);
        $entityManager->flush();

        return $this->json(['message' => 'Groupe supprimé avec succès']);
    }

    private function serializeGroup(Group $group): array
    {
        return [
            'id' => $group->getId(),
            'name' => $group->getName(),
            'description' => $group->getDescription(),
            'color' => $group->getColor(),
            'isFavorite' => $group->isIsFavorite(),
            // Ajoutez d'autres champs si nécessaire
        ];
    }
}

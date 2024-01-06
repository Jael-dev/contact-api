<?php

namespace App\Controller;

use App\Entity\Group;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/group')]
class GroupController extends AbstractController
{

// Get the list of groups
    #[Route('/', name: 'app_group_index', methods: ['GET'])]
    public function index(GroupRepository $groupRepository): Response
    {

        $groups = $groupRepository->findAll();
        $data = [];

        foreach ($groups as $group) {
            $data[] = $this->serializeGroup($group);
        }

        return $this->json($data);
        
    }

    // Create a new group

    #[Route('/', name: 'app_group_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $group = new Group();
        $group->setName($data['name']);
        $group->setDescription($data['description']);
        $group->setColor($data['color']);
        $group->setIsFavorite($data['isFavorite']);

        $entityManager->persist($group);
        $entityManager->flush();

        $data = $this->serializeGroup($group);

        return $this->json($data, 201);
    }

    // Get a group

    #[Route('/{id}', name: 'app_group_show', methods: ['GET'])]
    public function show( int $id, GroupRepository $groupRepository, Request $request): Response
    {
        $group = $groupRepository->findGroupById($id);

        if (!$group) {
            return $this->json(['message' => 'Groupe non trouvé'], 404);
        }

        $data = $this->serializeGroup($group);

        return $this->json($data);
    }

    #[Route('/{id}', name: 'app_group_edit', methods: ['PUT'])]
    public function edit(Request $request,  GroupRepository $groupRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $group = $groupRepository->findGroupById($id);

        if (!$group) {
            return $this->json(['message' => 'Groupe non trouvé'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $group->setName($data['name']);
        $group->setDescription($data['description']);
        $group->setColor($data['color']);
        $group->setIsFavorite($data['isFavorite']);

        $entityManager->persist($group);
        $entityManager->flush();

        $data = $this->serializeGroup($group);

        return $this->json($data);
    }


    // Delete a group
    #[Route('/{id}', name: 'app_group_delete', methods: ['DELETE'])]
    public function delete(GroupRepository $groupRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $group = $groupRepository->findGroupById($id);

        if (!$group) {
            return $this->json(['message' => 'Groupe non trouvé'], 404);
        }

        $entityManager->persist($group);
        $entityManager->remove($group);
        $entityManager->flush();

        return $this->json(['message' => 'Groupe supprimé avec succès']);
    }

    // Serialize a group

    private function serializeGroup(Group $group): array
    {
        return [
            'id' => $group->getId(),
            'name' => $group->getName(),
            'description' => $group->getDescription(),
            'color' => $group->getColor(),
            'isFavorite' => $group->isIsFavorite(),
        ];
    }
}

<?php

namespace App\Repository;

use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Group>
 *
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }
    
    /**
     * @return Group[] Returns an array of all Group objects
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('g')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * @param int $id
     * @return Group|null Returns a Group object or null if not found
     */
    public function findGroupById(int $id): ?Group
    {
        return $this->find($id);
    }
    
    /**
     * @param Group $group
     */
    public function editGroup(Group $group): Group
    {
        $this->_em->persist($group);
        $this->_em->flush();
    }
    
    /**
     * @param Group $group
     */
    public function deleteGroup(Group $group): void
    {
        $this->_em->remove($group);
        $this->_em->flush();
    }

    /**
     * Creates a new group.
     *
     * @param Group $group The group to create
     * @return Group The created group
     */
    public function createGroup(Group $group): Group
    {
        $this->_em->persist($group);
        $this->_em->flush();

        return $group;
    }
}

    

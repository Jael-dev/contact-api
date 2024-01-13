<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }
    /**
     * @return Contact[] Returns an array of all Contact objects
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('g')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * @param int $id
     * @return Contact|null Returns a Contact object or null if not found
     */
    public function findContactById(int $id): ?Contact
    {
        return $this->find($id);
    }

    // Find by groupid
    /**
     * @return Contact[] Returns an array of Contact objects
     */      
    public function findByGroupId(int $id): array
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.groupId = :val')
            ->setParameter('val', $id)
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // search in all fields

    /**
     * @return Contact[] Returns an array of Contact objects
     */

    public function search(string $search): array
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.first_name LIKE :val')
            ->orWhere('g.last_name LIKE :val')
            ->orWhere('g.phone_number LIKE :val')
            ->orWhere('g.email LIKE :val')
            ->orWhere('g.photo LIKE :val')
            ->orWhere('g.birthdate LIKE :val')
            ->orWhere('g.is_favorite LIKE :val')
            ->orWhere('g.group_id LIKE :val')
            ->setParameter('val', '%'.$search.'%')
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // search in all fields

    /**
     * @return Contact[] Returns an array of Contact objects
     */

    public function searchByGroupId(string $search, int $id): array

    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.first_name LIKE :val')
            ->orWhere('g.last_name LIKE :val')
            ->orWhere('g.phone_number LIKE :val')
            ->orWhere('g.email LIKE :val')
            ->orWhere('g.photo LIKE :val')
            ->orWhere('g.birthdate LIKE :val')
            ->orWhere('g.is_favorite LIKE :val')
            ->orWhere('g.group_id LIKE :val')
            ->andWhere('g.group_id = :val2')
            ->setParameter('val', '%'.$search.'%')
            ->setParameter('val2', $id)
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    // search in all fields and additional fields

    /**
     * @return Contact[] Returns an array of Contact objects
     */

    public function searchWithAdditionalFields(string $search): array
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.first_name LIKE :val')
            ->orWhere('g.last_name LIKE :val')
            ->orWhere('g.phone_number LIKE :val')
            ->orWhere('g.email LIKE :val')
            ->orWhere('g.photo LIKE :val')
            ->orWhere('g.birthdate LIKE :val')
            ->orWhere('g.is_favorite LIKE :val')
            ->orWhere('g.group_id LIKE :val')
            ->orWhere('g.additional_fields LIKE :val')
            ->setParameter('val', '%'.$search.'%')
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
 
}

<?php

namespace App\Repository;

use App\Entity\ContactHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContactHistory>
 *
 * @method ContactHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactHistory[]    findAll()
 * @method ContactHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactHistory::class);
    }
 /**
     * @return ContactHistory[] Returns an array of all ContactHistory objects
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('g')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * @param int $id
     * @return ContactHistory|null Returns a ContactHistory object or null if not found
     */
    public function findContactHistoryById(int $id): ?ContactHistory
    {
        return $this->find($id);
    }
}

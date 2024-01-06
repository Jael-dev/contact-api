<?php

namespace App\Repository;

use App\Entity\AdditionalField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdditionalField>
 *
 * @method AdditionalField|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdditionalField|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdditionalField[]    findAll()
 * @method AdditionalField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdditionalFieldRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdditionalField::class);
    }

     /**
     * @return AdditionalField[] Returns an array of all AdditionalField objects
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('g')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * @param int $id
     * @return AdditionalField|null Returns a AdditionalField object or null if not found
     */
    public function findAdditionalFieldById(int $id): ?AdditionalField
    {
        return $this->find($id);
    }
}

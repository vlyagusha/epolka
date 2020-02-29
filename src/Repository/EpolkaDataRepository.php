<?php

namespace App\Repository;

use App\Entity\EpolkaData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EpolkaData|null find($id, $lockMode = null, $lockVersion = null)
 * @method EpolkaData|null findOneBy(array $criteria, array $orderBy = null)
 * @method EpolkaData[]    findAll()
 * @method EpolkaData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EpolkaDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EpolkaData::class);
    }

    // /**
    //  * @return EpolkaData[] Returns an array of EpolkaData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EpolkaData
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
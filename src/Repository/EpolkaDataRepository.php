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

    /**
     * @param string $period
     * @return array|EpolkaData[]
     * @throws \Exception
     */
    public function getReportData(string $period): array
    {
        return $this->createQueryBuilder('epolkaData')
            ->andWhere('epolkaData.connectedAt >= :connectedAt')
                ->setParameter('connectedAt', new \DateTime($period))
            ->getQuery()
            ->getResult()
        ;
    }
}

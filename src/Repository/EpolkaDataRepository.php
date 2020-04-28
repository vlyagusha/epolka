<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\EpolkaData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

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

    public function getReportData(\DateTime $period): array
    {
        return $this->createQueryBuilder('epolkaData')
            ->andWhere('epolkaData.connectedAt >= :connectedAt')
                ->setParameter('connectedAt', $period)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getUniqueReportData(\DateTime $period): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult(EpolkaData::class, 'epolka_data');
        $rsm->addFieldResult('epolka_data', 'id', 'id');
        $rsm->addFieldResult('epolka_data', 'epolka_id', 'epolkaId');
        $rsm->addFieldResult('epolka_data', 'connected_at', 'connectedAt');
        $rsm->addFieldResult('epolka_data', 'connect_id', 'connectId');
        $rsm->addFieldResult('epolka_data', 'voltage', 'voltage');
        $rsm->addFieldResult('epolka_data', 'signal_level', 'signalLevel');
        $rsm->addFieldResult('epolka_data', 'sensors', 'sensors');

        return $this->getEntityManager()
            ->createNativeQuery('
                select * from epolka_data
                inner join (
                select epolka_id, max(connected_at) as connected_at
                from epolka_data
                where connected_at >= :connectedAt
                group by epolka_id ) tmp using (epolka_id, connected_at);
                ', $rsm)
            ->setParameter('connectedAt', $period)
            ->getResult();
    }
}

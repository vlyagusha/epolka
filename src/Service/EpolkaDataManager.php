<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\EpolkaData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class EpolkaDataManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handleRequest(Request $request): EpolkaData
    {
        $epolkaData = new EpolkaData();
        $epolkaData->setEpolkaId($request->query->get('epolka_id'));
        $epolkaData->setConnectedAt(new \DateTime('now', new \DateTimeZone('Europe/Moscow')));
        $epolkaData->setConnectId($request->query->getInt('connect_id'));
        $epolkaData->setVoltage($request->query->get('voltage'));
        $epolkaData->setSignalLevel($request->query->get('signal_level'));
        $sensors = explode(';', $request->query->get('sensors'));
        $sensors = array_filter($sensors);
        $sensors = array_map('floatval', $sensors);
        $epolkaData->setSensors($sensors);

        return $epolkaData;
    }

    public function storeEpolkaData(EpolkaData $epolkaData): void
    {
        $this->entityManager->persist($epolkaData);
        $this->entityManager->flush();
    }
}

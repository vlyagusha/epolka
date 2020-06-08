<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\EpolkaData;
use App\Entity\EpolkaSettings;
use App\Entity\TestEpolkaId;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;

class EpolkaSettingsManager
{
    private string $host;
    private string $altHost;
    private int $connectionInterval;
    private int $altConnectionInterval;
    private RouterInterface $router;
    private EntityManagerInterface $entityManager;

    public function __construct(string $host, string $altHost, int $connectionInterval, int $altConnectionInterval, RouterInterface $router, EntityManagerInterface $entityManager)
    {
        $this->host = $host;
        $this->altHost = $altHost;
        $this->connectionInterval = $connectionInterval;
        $this->altConnectionInterval = $altConnectionInterval;
        $this->router = $router;
        $this->entityManager = $entityManager;
    }

    public function getSettings(EpolkaData $epolkaData): EpolkaSettings
    {
        $epolkaSettings = new EpolkaSettings();
        $epolkaSettings->setConnectionPath($this->router->generate('app_store_data', [], RouterInterface::ABSOLUTE_PATH));

        $epolkaTestId = $this->entityManager->getRepository(TestEpolkaId::class)->find($epolkaData->getEpolkaId());
        if ($epolkaTestId !== null) {
            $epolkaSettings->setConnectionInterval($this->altConnectionInterval);
            $epolkaSettings->setConnectionHost($this->altHost);
        } else {
            $epolkaSettings->setConnectionInterval($this->connectionInterval);
            $epolkaSettings->setConnectionHost($this->host);
        }

        return $epolkaSettings;
    }
}

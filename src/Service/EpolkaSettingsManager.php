<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\EpolkaSettings;
use Symfony\Component\Routing\RouterInterface;

class EpolkaSettingsManager
{
    private string $host;

    private int $connectionInterval;

    private RouterInterface $router;

    public function __construct(string $host, int $connectionInterval, RouterInterface $router)
    {
        $this->host = $host;
        $this->connectionInterval = $connectionInterval;
        $this->router = $router;
    }

    public function getSettings(): EpolkaSettings
    {
        $epolkaSettings = new EpolkaSettings();
        $epolkaSettings->setConnectionInterval($this->connectionInterval);
        $epolkaSettings->setConnectionHost($this->host);
        $epolkaSettings->setConnectionPath($this->router->generate('app_store_data', [], RouterInterface::ABSOLUTE_PATH));

        return $epolkaSettings;
    }
}

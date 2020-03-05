<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\EpolkaSettings;
use Symfony\Component\Routing\RouterInterface;

class EpolkaSettingsManager
{
    private string $host;

    private RouterInterface $router;

    public function __construct(string $host, RouterInterface $router)
    {
        $this->host = $host;
        $this->router = $router;
    }

    public function getSettings(): EpolkaSettings
    {
        $epolkaSettings = new EpolkaSettings();
        $epolkaSettings->setConnectionInterval(24 * 60 * 60);
        $epolkaSettings->setConnectionHost($this->router->generate('app_store_data', [], RouterInterface::ABSOLUTE_URL));

        return $epolkaSettings;
    }
}

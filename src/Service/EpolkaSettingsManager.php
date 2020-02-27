<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\EpolkaSettings;

class EpolkaSettingsManager
{
    public function getSettings(): EpolkaSettings
    {
        $epolkaSettings = new EpolkaSettings();
        $epolkaSettings->setConnectionInterval('1 day');

        return $epolkaSettings;
    }
}

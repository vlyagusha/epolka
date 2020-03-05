<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\EpolkaSettings;

class EpolkaFormatter
{
    public function formatArray(EpolkaSettings $epolkaSettings): array
    {
        return $epolkaSettings->jsonSerialize();
    }

    public function formatString(EpolkaSettings $epolkaSettings): string
    {
        return implode(';', $epolkaSettings->jsonSerialize());
    }
}

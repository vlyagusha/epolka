<?php declare(strict_types=1);

namespace App\Event;

use App\Entity\EpolkaData;
use Symfony\Contracts\EventDispatcher\Event;

class ReportEvent extends Event
{
    private array $report;

    public function __construct(array $report)
    {
        $this->report = $report;
    }

    /**
     * @return array|EpolkaData[]
     */
    public function getReport(): array
    {
        return $this->report;
    }
}

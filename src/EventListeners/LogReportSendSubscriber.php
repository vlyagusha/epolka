<?php declare(strict_types=1);

namespace App\EventListeners;

use App\Event\ReportEvent;
use App\Event\ReportEvents;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LogReportSendSubscriber implements EventSubscriberInterface
{
    private LoggerInterface $reportLogger;

    public function __construct(LoggerInterface $reportLogger)
    {
        $this->reportLogger = $reportLogger;
    }

    public static function getSubscribedEvents()
    {
        return [
            ReportEvents::ON_SEND => 'onReportSend',
        ];
    }

    public function onReportSend(ReportEvent $event): void
    {
        if (empty($event->getReport())) {
            $this->reportLogger->warning('Report data is empty!');

            return;
        }

        foreach ($event->getReport() as $report) {
            $reportData = implode(';', [
                $report->getEpolkaId(),
                $report->getConnectedAt()->format('Y-m-d H:i:s'),
                $report->getSignalLevel(),
                $report->getVoltage(),
                implode(';', $report->getSensors())
            ]);

            $this->reportLogger->info('Sent report: ' . $reportData);
        }

        return;
    }
}

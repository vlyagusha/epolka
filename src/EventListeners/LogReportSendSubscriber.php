<?php declare(strict_types=1);

namespace App\EventListeners;

use App\Event\ReportEvent;
use App\Event\ReportEvents;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LogReportSendSubscriber implements EventSubscriberInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $reportLogger)
    {
        $this->logger = $reportLogger;
    }

    public static function getSubscribedEvents()
    {
        return [
            ReportEvents::ON_SEND => 'onReportSend',
        ];
    }

    public function onReportSend(ReportEvent $event): void
    {
        if ($event->getTextReport() === null) {
            $this->logger->warning('Report data is empty!');

            return;
        }

        foreach (explode("\n", $event->getTextReport()) as $report) {
            $this->logger->info('Sent report: ' . $report);
        }

        return;
    }
}

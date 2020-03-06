<?php declare(strict_types=1);

namespace App\EventListeners;

use App\Event\ReportEvent;
use App\Event\ReportEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FtpReportSendSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ReportEvents::ON_SEND => 'onReportSend',
        ];
    }

    public function onReportSend(ReportEvent $event): void
    {

    }
}

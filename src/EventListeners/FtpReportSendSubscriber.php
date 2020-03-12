<?php declare(strict_types=1);

namespace App\EventListeners;

use App\Event\ReportEvent;
use App\Event\ReportEvents;
use App\Service\FtpClient;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FtpReportSendSubscriber implements EventSubscriberInterface
{
    private FtpClient $ftpClient;

    private string $path;

    public function __construct(FtpClient $ftpClient, string $path)
    {
        $this->ftpClient = $ftpClient;
        $this->path = $path;
    }

    public static function getSubscribedEvents()
    {
        return [
            ReportEvents::ON_SEND => 'onReportSend',
        ];
    }

    public function onReportSend(ReportEvent $event): void
    {
        $reportData = $event->getTextReport() ?? '';

        $fileName = sprintf('report_%s.csv', (new \DateTime('now', new \DateTimeZone('Europe/Moscow')))->format('Y-m-d_H:i:s'));
        $localFileName = $this->path . $fileName;

        file_put_contents($localFileName, $reportData);

        $this->ftpClient->upload($fileName, $localFileName);

        unlink($localFileName);

        return;
    }
}

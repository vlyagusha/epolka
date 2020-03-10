<?php declare(strict_types=1);

namespace App\EventListeners;

use App\Event\ReportEvent;
use App\Event\ReportEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailReportSendSubscriber implements EventSubscriberInterface
{
    private MailerInterface $mailer;

    private array $reportEmailRecipients;

    private string $reportEmailSender;

    public function __construct(MailerInterface $mailer, array $reportEmailRecipients, string $reportEmailSender)
    {
        $this->mailer = $mailer;
        $this->reportEmailRecipients = $reportEmailRecipients;
        $this->reportEmailSender = $reportEmailSender;
    }

    public static function getSubscribedEvents()
    {
        return [
            ReportEvents::ON_SEND => 'onReportSend',
        ];
    }

    public function onReportSend(ReportEvent $event): void
    {
        $reportData = 'Report data is empty!';

        if (!empty($event->getReport())) {
            $reportData = [];
            foreach ($event->getReport() as $report) {
                $reportData[] = implode(';', [
                    $report->getEpolkaId(),
                    $report->getConnectedAt()->format('Y-m-d H:i:s'),
                    $report->getSignalLevel(),
                    $report->getVoltage(),
                    implode(';', $report->getSensors())
                ]);
            }
            $reportData = implode("\n", $reportData);
        }

        $reportEmail = (new Email())
            ->from($this->reportEmailSender)
            ->to(...$this->reportEmailRecipients)
            ->subject('Epolka report')
            ->text($reportData)
        ;

        $this->mailer->send($reportEmail);

        return;
    }
}

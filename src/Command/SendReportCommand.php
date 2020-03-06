<?php declare(strict_types=1);

namespace App\Command;

use App\Entity\EpolkaData;
use App\Event\ReportEvent;
use App\Event\ReportEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SendReportCommand extends Command
{
    protected static $defaultName = 'app:report:send';

    private EventDispatcherInterface $eventDispatcher;

    private EntityManagerInterface $entityManager;

    public function __construct(EventDispatcherInterface $eventDispatcher, EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->eventDispatcher = $eventDispatcher;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Рассылает отчёты')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $report = $this->entityManager->getRepository(EpolkaData::class)->getReportData('-1 day');

        $this->eventDispatcher->dispatch(new ReportEvent($report), ReportEvents::ON_SEND);

        return 0;
    }
}

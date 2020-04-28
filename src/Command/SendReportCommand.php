<?php declare(strict_types=1);

namespace App\Command;

use App\Entity\EpolkaData;
use App\Event\ReportEvent;
use App\Event\ReportEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
            ->addOption('period', null, InputOption::VALUE_REQUIRED);
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $period = new \DateTime($input->getOption('period'), new \DateTimeZone('Europe/Moscow'));
        $report = $this->entityManager->getRepository(EpolkaData::class)->getUniqueReportData($period);

        $this->eventDispatcher->dispatch(new ReportEvent($report), ReportEvents::ON_SEND);

        return 0;
    }
}

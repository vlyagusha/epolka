<?php declare(strict_types=1);

namespace App\Command;

use App\Event\ReportEvent;
use App\Event\ReportEvents;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SendReportCommand extends Command
{
    protected static $defaultName = 'app:report:send';

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct();

        $this->eventDispatcher = $eventDispatcher;
    }

    protected function configure()
    {
        $this
            ->setDescription('Рассылает отчёты')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->eventDispatcher->dispatch(new ReportEvent([]), ReportEvents::ON_SEND);

        return 0;
    }
}

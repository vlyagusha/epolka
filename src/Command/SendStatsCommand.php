<?php declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendStatsCommand extends Command
{
    protected static $defaultName = 'app:stats:send';

    protected function configure()
    {
        $this
            ->setDescription('Отправляет email со статистикой')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return 0;
    }
}

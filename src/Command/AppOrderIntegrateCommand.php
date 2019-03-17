<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppOrderIntegrateCommand extends Command
{
    protected static $defaultName = 'app:order:integrate';

    protected function configure()
    {
        $this
            ->setDescription('')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $output->writeln([
            'Compute rotation rate',
            '============',
            '',
        ]);
//
//        $computeRotation = new ComputeRotation($);
//        $statement = $this->connection->executeQuery('SELECT build_routine(\''.$name.'\', \''.$content.'\')');
//        $statement->fetchAll();
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}

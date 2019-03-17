<?php

namespace App\Command;

use App\Domain\ComputeRotation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ProductIntegrateCommand extends Command
{
    protected static $defaultName = 'app:product:integrate';

    private $computeRotation;

    public function __construct(ComputeRotation $computeRotation, $name = null)
    {
        $this->computeRotation = $computeRotation;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
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

        $computeRotation = new ComputeRotation();
        $statement = $this->connection->executeQuery('SELECT build_routine(\''.$name.'\', \''.$content.'\')');
        $statement->fetchAll();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}

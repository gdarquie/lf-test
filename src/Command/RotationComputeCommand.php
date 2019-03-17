<?php

namespace App\Command;

use App\Domain\ComputeRotation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RotationComputeCommand extends Command
{
    protected static $defaultName = 'app:rotation:compute';

    private $computeRotation;

    public function __construct(ComputeRotation $computeRotation, $name = null)
    {
        $this->computeRotation = $computeRotation;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Compute rotation rate for product = number of sold products by week')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->computeRotation->process();

        $io->success('Rotation computation succed!');
    }
}

<?php

namespace App\Command;

use App\Domain\ComputeRotation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * We used here a procedure to show we can have different possibilities to integrate data, this way is very performant but it is not directly in the php application : we use plpgsql function to compute the rotation and update products data.
 *
 * Using plpgsql can be usefull if we would like to manage millions of data, but in this test it is not required, I change wanted to show a way for optimization if it is needed one day
 *
 * Class RotationComputeCommand
 * @package App\Command
 */
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

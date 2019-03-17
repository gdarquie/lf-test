<?php

namespace App\Command;

use App\Feeder\Feeder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

class AppOrderIntegrateCommand extends Command
{
    protected static $defaultName = 'app:order:integrate';

    /**
     * @var Feeder
     */
    private $feeder;

    protected function configure()
    {
        $this
            ->setDescription('Integrate order')
        ;
    }

    /**
     * AppOrderIntegrateCommand constructor.
     * @param Finder $finder
     * @param Feeder $feeder
     * @param null $name
     */
    public function __construct(Feeder $feeder, $name = null)
    {
        $this->feeder = $feeder;
        parent::__construct($name);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $output->writeln([
            'Order integration',
            '============',
            '',
        ]);

        $finder = new Finder();
        $finder->files()->in('data');

        // get all files
        $files = [];
        foreach ($finder as $file) {
            array_push($files, $file->getRealPath());
        }

        //todo : add a system for selecting a new file


        // integrate
        $this->feeder->integrateOrder($files[0]);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}

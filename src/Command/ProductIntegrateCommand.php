<?php

namespace App\Command;

use App\Feeder\Feeder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

class ProductIntegrateCommand extends Command
{
    protected static $defaultName = 'app:product:integrate';

    /**
     * @var Feeder
     */
    private $feeder;

    /**
     * ProductIntegrateCommand constructor.
     * @param Feeder $feeder
     * @param null $name
     */
    public function __construct(Feeder $feeder, $name = null)
    {
        $this->feeder = $feeder;
        parent::__construct($name);
    }


    protected function configure()
    {
        $this
            ->setDescription('Product integration')
        ;
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
            'Product integration',
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
        $this->feeder->integrateProduct($files[1]);

        $io->success('Products have been integrated');
    }
}

<?php

namespace App\Command;

use App\Command\PopulateCategoriesCommand;
use App\Command\PopulateTaxesCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateOnDeployCommand extends Command
{
    protected static $defaultName = 'app:populate-on-deploy';

    private $populateCategoriesCommand;
    private $populateTaxesCommand;

    function __construct(
        PopulateCategoriesCommand $populateCategoriesCommand,
        PopulateTaxesCommand $populateTaxesCommand)
    {
        $this->populateCategoriesCommand = $populateCategoriesCommand;
        $this->populateTaxesCommand = $populateTaxesCommand;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Populate master tables on deploy')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->populateCategoriesCommand->populateCategories();
        $this->populateTaxesCommand->populateTaxes();
    }
}

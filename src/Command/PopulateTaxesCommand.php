<?php

namespace App\Command;

use App\Entity\Tax;
use App\Repository\TaxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateTaxesCommand extends Command
{
    protected static $defaultName = 'app:populate-taxes';

    private $entityManager;
    private $taxesRepository;

    function __construct(
        EntityManagerInterface $entityManager,
        TaxRepository $taxRepository)
    {
        $this->entityManager = $entityManager;
        $this->taxRepository = $taxRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Populate taxes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->populateTaxes();
    }

    public function populateTaxes()
    {
        $taxes[] = ['name' => Tax::IVA, 'value' => 21];
        $taxes[] = ['name' => Tax::IGIC, 'value' => 7];

        foreach($taxes as $tax)
        {
            $taxExists = $this->taxRepository->findOneBy(['name' => $tax['name']]);
            if($taxExists instanceof Tax)
                continue;

            $taxToPersist = new Tax();
            $taxToPersist->setName($tax['name']);
            $taxToPersist->setValue($tax['value']);
            $this->entityManager->persist($taxToPersist);
        }

        $this->entityManager->flush();
        echo "\n Taxes has been populated.";
    }
}

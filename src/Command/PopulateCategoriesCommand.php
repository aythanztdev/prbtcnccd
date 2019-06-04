<?php

namespace App\Command;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateCategoriesCommand extends Command
{
    protected static $defaultName = 'app:populate-categories';

    private $entityManager;
    private $categoryRepository;

    function __construct(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Populate categories')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->populateCategories();
    }

    public function populateCategories()
    {
        $categories[] = ['name' => Category::TEXTIL];
        $categories[] = ['name' => Category::BOOKS];
        $categories[] = ['name' => Category::SPORT];
        $categories[] = ['name' => Category::FURNITURE];

        foreach($categories as $category)
        {
            $categoryExists = $this->categoryRepository->findOneBy(['name' => $category['name']]);
            if($categoryExists instanceof Category)
                continue;

            $categoryToPersist = new Category();
            $categoryToPersist->setName($category['name']);
            $this->entityManager->persist($categoryToPersist);
        }

        $this->entityManager->flush();
        echo "\n Categories has been populated.";
    }
}

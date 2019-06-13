<?php

namespace App\Command;

use App\Csv\ProductCsvGeneratorInterface;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportProductCommand extends Command
{
    protected static $defaultName = 'app:export:product';

    /** @var ProductRepository */
    private $productRepository;

    /** @var ProductCsvGeneratorInterface */
    private $productCsvGenerator;

    public function __construct(ProductRepository $productRepository, ProductCsvGeneratorInterface $productCsvGenerator)
    {
        parent::__construct();

        $this->productRepository = $productRepository;
        $this->productCsvGenerator = $productCsvGenerator;
    }

    protected function configure()
    {
        $this
            ->setDescription('Exporter les produits en CSV')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = $this->productRepository->findDisplayable();

        $csv = $this->productCsvGenerator->generate($products);

        $output->write($csv->getContent());
    }
}

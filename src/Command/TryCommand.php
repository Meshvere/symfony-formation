<?php
namespace App\Command;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
class TryCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:try';
    protected function configure()
    {
        $this
            ->setDescription('Dev sandbox')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $product = new Product();
//        $product->setLabel('Mon produit 2');
//        $product->setDescription('Mon produit 2');
//        $product->setSlug('mon-produit-2');
//        $product->setPrice(1000);
//
//        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
//
//        $entityManager->persist($product);
//        $entityManager->flush($product);
        //
        //return;
        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        /** @var ProductRepository $productRepository */
        $productRepository = $entityManager->getRepository(Product::class);

        $product = $productRepository->findOneById(3);
        $productRepository->delete($product);
        //$product->setPrice(2000);
        //
        //$entityManager->flush($product);

        $products = $productRepository->findNotDeleted();
        dump($products);
    }
}
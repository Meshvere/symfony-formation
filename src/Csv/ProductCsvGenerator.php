<?php


namespace App\Csv;


use App\Entity\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Webmozart\Assert\Assert;

class ProductCsvGenerator implements ProductCsvGeneratorInterface
{
    /** @var SerializerInterface */
    private $serializer;

    /**
     * ProductCsvGenerator constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    public function generate(array $products): ProductCsvInterface
    {
        Assert::allIsInstanceOf($products, Product::class); // Vérifie que tous les éléments de $products est bien de type Product, error si non

        $csv = $this->serializer->serialize($products, 'csv');

        return new ProductCsv($csv);
    }
}
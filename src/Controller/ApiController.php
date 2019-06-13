<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    public const PRODUCTS_PER_PAGE = 2;

    /** @var ProductRepository */
    private $productRepository;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(ProductRepository $productRepository, SerializerInterface $serializer)
    {
        $this->productRepository = $productRepository;
        $this->serializer = $serializer;
    }

    public function getProduct(Request $request)
    {
        $product = $this->productRepository->find($request->attributes->getInt('id'));

        if (null === $product) {
            throw new NotFoundHttpException(sprintf('Product with id %d not found', $request->attributes->getInt('id')));
        }

        return JsonResponse::fromJsonString($this->serializer->serialize($product, 'json'));
    }

    public function getProducts(Request $request)
    {
        $page = $request->query->getInt('page', 1);

        $productsPaginator = $this->productRepository->createPaginatorForDisplayableProducts(
            ($page - 1) * self::PRODUCTS_PER_PAGE,
            self::PRODUCTS_PER_PAGE
        );

        $response = JsonResponse::fromJsonString($this->serializer->serialize(iterator_to_array($productsPaginator), 'json'));
        $response->headers->set('X-TOTAL-COUNT', count($productsPaginator));
        return $response;
    }
}

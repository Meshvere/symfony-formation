<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    public const PRODUCTS_PER_PAGE = 5;

    public function getProduct(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->find(Product::class, $request->attributes->getInt('id'));

        if (null === $product) {
            throw new NotFoundHttpException(sprintf('Product with id %d not found', $request->attributes->getInt('id')));
        }

        $serializer = $this->get('serializer');
        return JsonResponse::fromJsonString($serializer->serialize($product, 'json'));
    }

    public function getProducts(Request $request)
    {
        $page = $request->query->getInt('page', 1);
        $entityManager = $this->container->get('doctrine');
        /** @var ProductRepository $productRepository */
        $productRepository = $entityManager->getRepository(Product::class);
        $productsPaginator = $productRepository->createPaginatorForDisplayableProducts(
            ($page - 1) * self::PRODUCTS_PER_PAGE,
            self::PRODUCTS_PER_PAGE
        );
        $serializer = $this->get('serializer');
        $response = JsonResponse::fromJsonString($serializer->serialize(iterator_to_array($productsPaginator), 'json'));
        $response->headers->set('X-TOTAL-COUNT', count($productsPaginator));
        return $response;
    }
}

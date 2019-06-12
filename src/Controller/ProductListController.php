<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductListController extends AbstractController
{
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $productRepository = $entityManager->getRepository(Product::class);

        $products = $productRepository->findDisplayable();//findNotDeleted();

        return $this->render('product_list/index.html.twig', [
            'controller_name' => 'ProductListController', 'products'=>$products
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\TaxRate;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductTypeController extends AbstractController
{
    public function create(Request $request)
    {
        $product = new Product();
        $taxRate = $this->getDoctrine()->getManager()->find(TaxRate::class, -1);
        $product->setTaxRate($taxRate);

        $form = $this->createForm(ProductType::class, $product);

        if ($request->isMethod('POST') && $form->handleRequest($request) && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', 'Le produit a été créé');
        }

        return $this->render('product_type/index.html.twig', [
            'controller_name' => 'TaxRateTypeController',
            'form'=>$form->createView()
        ]);
    }
}

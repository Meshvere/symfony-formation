<?php

namespace App\Controller;

use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaxRateTypeController
{

    public function create(Request $request)
    {
        $form = $this->createForm(TaxRateType::class, new TaxRate(), ['validation_groups' => ['Default', 'safe']]);

        if ($request->isMethod('POST') && $form->handleRequest($request) && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', 'Le taux de taxe a été créé');
        }

        return $this->render('tax_rate_type/index.html.twig', [
            'controller_name' => 'TaxRateTypeController',
            'form'=>$form->createView()
        ]);
    }

    public function edit(Request $request, $id)
    {
        $product = $this->productRepository->find($request->attributes->getInt('id'));
        if (null === $product) {
            throw new NotFoundHttpException(sprintf('Product with id %d not found', $request->attributes->getInt('id')));
        }
        $form = $this->formFactory->create(ProductType::class, $product, [
            'method' => 'PATCH',
            'context' => 'partial-edit',
        ]);
        if ($request->isMethod('PATCH') && $form->handleRequest($request) && $form->isValid()) {
            $this->productRepository->add($form->getData());
            $this->flashBag->add('success', 'Le produit a été modifié');
        }

        return $this->render('tax_rate_type/index.html.twig', [
            'controller_name' => 'TaxRateTypeController',
            'form'=>$form->createView()
        ]);
    }
}

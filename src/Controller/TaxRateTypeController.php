<?php

namespace App\Controller;

use App\Entity\TaxRate;
use App\Form\TaxRateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaxRateTypeController extends AbstractController
{
    public function create(Request $request)
    {
        $form = $this->createForm(TaxRateType::class, new TaxRate());

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
        $entityManager = $this->getDoctrine()->getManager();
        $taxRate = $entityManager->find(TaxRate::class, $request->attributes->getInt('id'));
        if (null === $taxRate) {
            throw new NotFoundHttpException(sprintf('Tax Rate with id %d not found', $request->attributes->getInt('id')));
        }
        $form = $this->createForm(TaxRateType::class, $taxRate, [
            'method' => 'PATCH',
        ]);
        if ($request->isMethod('PATCH') && $form->handleRequest($request) && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', 'La taxe a été modifiée');
        }

        return $this->render('tax_rate_type/index.html.twig', [
            'controller_name' => 'TaxRateTypeController',
            'form'=>$form->createView()
        ]);
    }
}

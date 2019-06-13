<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\TaxRate;
use App\Event\ProductPreUpdateEvent;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class ProductTypeController extends AbstractController
{
    /** @var ProductRepository */
    private $productRepository;
    /** @var FormFactoryInterface */
    private $formFactory;
    /** @var EventDispatcherInterface|EventDispatcher */
    private $eventDispatcher;
    /** @var FlashBagInterface */
    private $flashBag;
    /** @var Environment */
    private $templating;

    public function __construct(
        ProductRepository $productRepository,
        FormFactoryInterface $formFactory,
        EventDispatcherInterface $eventDispatcher,
        FlashBagInterface $flashBag,
        Environment $templating
    ) {
        $this->productRepository = $productRepository;
        $this->formFactory = $formFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->flashBag = $flashBag;
        $this->templating = $templating;
    }

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

    public function edit(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->find(Product::class, $request->attributes->getInt('id'));
        if (null === $product) {
            throw new NotFoundHttpException(sprintf('Product with id %d not found', $request->attributes->getInt('id')));
        }
        $form = $this->createForm(ProductType::class, $product, [
            'method' => 'PATCH'
        ]);
        if ($request->isMethod('PATCH') && $form->handleRequest($request) && $form->isValid()) {
            $this->eventDispatcher->dispatch(new ProductPreUpdateEvent($product), ProductPreUpdateEvent::NAME);
            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', 'Le produit a été modifié');
        }

        return $this->render('product_type/index.html.twig', [
            'controller_name' => 'ProductTypeController',
            'form'=>$form->createView()
        ]);
    }
}

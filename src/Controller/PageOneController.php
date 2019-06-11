<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageOneController extends AbstractController
{
    /**
     * @Route("/page/one", name="page_one")
     */
    public function index()
    {
        return $this->render('page_one/index.html.twig', [
            'controller_name' => 'PageOneController',
        ]);
    }
}

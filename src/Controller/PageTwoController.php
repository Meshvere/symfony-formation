<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageTwoController extends AbstractController
{
    /**
     * @Route("/page/two", name="page_two")
     */
    public function index()
    {
        return $this->render('page_two/index.html.twig', [
            'controller_name' => 'PageTwoController',
        ]);
    }
}

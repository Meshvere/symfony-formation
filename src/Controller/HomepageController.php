<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HomepageController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $contactInformation = $this->getParameter('app.contact_information');
        return $this->render('homepage.html.twig');
    }
}
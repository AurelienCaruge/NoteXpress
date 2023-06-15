<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HompageController extends AbstractController
{
    #[Route('/', name: 'app_hompage')]
    public function index(): Response
    {
        return $this->render('hompage/hompage.html.twig', [
            'controller_name' => 'HompageController',
        ]);
    }
}

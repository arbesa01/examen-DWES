<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HolaController extends AbstractController
{
    #[Route('/hola', name: 'app_hola')]
    public function index(): Response
    {
        return $this->render('hola/index.html.twig', [
            'controller_name' => 'HolaController',
        ]);
    }
}

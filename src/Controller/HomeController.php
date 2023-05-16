<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'title' => 'home'
        ]);
    }

    #[Route('/about', name: 'about', methods: ['GET'])]
    public function about(): Response 
    {
        return $this->render('home/about.html.twig', [
            'title' => 'about'
        ]);
    }
}

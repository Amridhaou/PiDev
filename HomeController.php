<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('home');
    }

    #[Route('/home', name: 'home')]
    public function home(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/enseignant', name: 'enseignant')]
    public function ensignant(): Response
    {
        return $this->render('home/enseignant.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/etudiant', name: 'etudiant')]
    public function etudiant(): Response
    {
        return $this->render('home/etudiant.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

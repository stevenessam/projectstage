<?php

namespace App\Controller;

use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AProposController extends AbstractController
{
    #[Route('/about', name: 'app_a_propos')]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('a_propos/index.html.twig', [
            'commentaires' => $commentaireRepository->lastTree(),
            'titre' => 'A Propos - H.M.S RENOV',
        ]);
    }
}

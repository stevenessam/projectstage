<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(Request $request, CategorieRepository $categorieRepository): Response
    {

        $categorieType = $categorieRepository->findAll();
        $categorieD = $categorieType;

        return $this->render('categorie/index.html.twig', [
            'categorieType' => $categorieType,
            'titre' => 'Categories - H.M.S RENOV',
        ]);
    }
}



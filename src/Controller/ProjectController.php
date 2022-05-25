<?php

namespace App\Controller;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/project', name: 'app_project')]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('project/project.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }
}

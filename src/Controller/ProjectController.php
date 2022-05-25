<?php

namespace App\Controller;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/project', name: 'app_project')]
    public function index(
        ProjectRepository $projectRepository,
        PaginatorInterface $paginator,
        Request $request

        ): Response {

        $data = $projectRepository->findAll();

        $projects = $paginator->paginate(
        $data,
        $request->query->getInt('page',1),
        9
        );

        return $this->render('project/project.html.twig', [
            'projects' => $projects ,
        ]);
    }

    /**
      *  @Route("/project/{slug}",name="app_project_details")
      */
    public function details(Project $project): Response
    {

        return $this->render('project/details.html.twig', [
             'project'=>$project ,
        ]);


    }



}

<?php

namespace App\Controller;
use App\Entity\Project;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Service\CommentaireService;
use App\Repository\ProjectRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    #[Route('/project', name: 'app_project')]
    public function index(
        ProjectRepository $projectRepository,
        PaginatorInterface $paginator,
        Request $request,
        CategorieRepository $categorieRepository,
        ): Response {

        $data = $projectRepository->findBy([],['id'=>'DESC']);

        $projects = $paginator->paginate(
        $data,
        $request->query->getInt('page',1),
        9
        );

        $categorieisNames = $categorieRepository->findAll();
        $categories = $categorieisNames;

        return $this->render('project/project.html.twig', [
            'projects' => $projects ,
            'categorieisNames' => $categorieisNames,
            'titre' => 'Realisations',
        ]);
    }
    
    /**
      *  @Route("/project/{slug}",name="app_project_details")
      */
      public function details(
        Project $project,
        Request $request,
        CommentaireService $commentaireService,
        CommentaireRepository $commentaireRepository
        ): Response
        {
            $commentaires = $commentaireRepository->findCommentaires($project);
            $commentaire=new Commentaire();
            $form= $this->createForm(CommentaireType::class, $commentaire);
            $form->handleRequest($request);
            
            if($form->isSubmitted()&& $form->isValid()){
                $commentaire=$form->getData();
                $commentaireService->persistCommentaire($commentaire,null,$project);
                return $this->redirectToRoute('app_project_details',['slug' => $project->getSlug()]);
            }
    
    
            return $this->render('project/details.html.twig', [
                 'project'=>$project,
                 'form' =>$form->createView(),
                 'commentaires'=>$commentaires,
            ]);
    
    
        }

    // /**
    //   *  @Route("/project/{slug}",name="app_project_details")
    //   */
    // public function details(Project $project): Response
    // {

    //     return $this->render('project/details.html.twig', [
    //          'project'=>$project ,
    //     ]);


    // }



    


}

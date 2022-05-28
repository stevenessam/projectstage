<?php
namespace App\Service;

use DateTime;
use App\Entity\Project;
use App\Entity\Blogpost;
use App\Entity\Commentaire;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CommentaireService
{
    private $manager;
   
    public function __construct(EntityManagerInterface $manager)
   {
        $this->manager= $manager;
       
    }

    public function persistCommentaire(
        Commentaire $commentaire,
        Blogpost $blogpost=null,
        Project $project=null
    ): void {
        $commentaire->setIsPublished(false)
                    ->setBlogpost($blogpost)
                    ->setProject($project)
                    ->setCreatedAt(new DateTime('now'));

        $this->manager->persist($commentaire);
        $this->manager->flush();
        

        }
}
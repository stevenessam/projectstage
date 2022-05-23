<?php

namespace App\Tests;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Entity\Project;
use DateTime;
use PHPUnit\Framework\TestCase;

class CommentaireUnitTest extends TestCase
{
    public function testIsTrue ()
    {
        $commentaire = new Commentaire();
        $datetime = new DateTime();
        $blogpost = new Blogpost();
        $project = new Project();

        $commentaire->setAuteur ('auteur')
            ->setEmail ('email@test.com')
            ->setCreatedAt($datetime)
            ->setContenu ('contenu')
            ->setBlogpost ($blogpost)
            ->setProject ($project);
        
            $this->assertTrue ($commentaire->getAuteur () === 'auteur');
            $this->assertTrue ($commentaire->getEmail () ==='email@test.com');
            $this->assertTrue ($commentaire->getCreatedAt ()=== $datetime );
            $this->assertTrue ( $commentaire->getContenu () ==='contenu');
            $this->assertTrue ( $commentaire->getBlogpost () === $blogpost);
            $this->assertTrue ( $commentaire->getProject () === $project);
    }


    public function testIsFalse ()
    {
        $commentaire = new Commentaire();
        $datetime = new DateTime();
        $blogpost = new Blogpost();
        $project = new Project();

        $commentaire->setAuteur ('false')
            ->setEmail ('false@test.com')
            ->setCreatedAt(new DateTime())
            ->setContenu ('false')
            ->setBlogpost (new Blogpost())
            ->setProject (new Project());
        
            $this->assertFalse ($commentaire->getAuteur () === 'auteur');
            $this->assertFalse ($commentaire->getEmail () ==='email@test.com');
            $this->assertFalse ($commentaire->getCreatedAt ()=== $datetime );
            $this->assertFalse ( $commentaire->getContenu () ==='contenu');
            $this->assertFalse ( $commentaire->getBlogpost () === $blogpost);
            $this->assertFalse ( $commentaire->getProject () === $project);
    }

    public function testIsEmpty ()
    {
        $commentaire = new commentaire();
                
            $this->assertEmpty ($commentaire->getAuteur());
            $this->assertEmpty ($commentaire->getEmail());
            $this->assertEmpty ($commentaire->getCreatedAt());
            $this->assertEmpty ($commentaire->getContenu());
            $this->assertEmpty ($commentaire->getBlogpost());
            $this->assertEmpty ($commentaire->getProject());
    }



}
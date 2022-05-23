<?php

namespace App\Tests;

use App\Entity\Categorie;
use App\Entity\Project;
use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class ProjectUnitTest extends TestCase
{
    public function testIsTrue ()
    {

        $project = new Project();
        $datetime = new DateTime();
        $categorie = new Categorie();
        $user = new User();

        $project->setNom ('nom')
            ->setDateRealisation ($datetime)
            ->setCreatedAt ($datetime)
            ->setDescription('description')
            ->setSlug('slug')
            ->setFile('file')
            ->addCategorie($categorie)
            ->setUser($user);
        
            $this->assertTrue ($project->getNom ()=== 'nom' );
            $this->assertTrue ( $project->getDateRealisation () === $datetime);
            $this->assertTrue ( $project->getCreatedAt () === $datetime);
            $this->assertTrue ($project->getDescription ()=== 'description' );
            $this->assertTrue ($project->getSlug ()=== 'slug' );
            $this->assertTrue ($project->getFile ()=== 'file' );
            $this->assertContains ($categorie, $project->getCategorie());
            $this->assertTrue ($project->getUser ()=== $user);
            
    }


    public function testIsFalse ()
    {

        $project = new Project();
        $datetime = new DateTime();
        $categorie = new Categorie();
        $user = new User();

        $project->setNom ('nom')
            ->setDateRealisation ($datetime)
            ->setCreatedAt ($datetime)
            ->setDescription('description')
            ->setSlug('slug')
            ->setFile('file')
            ->addCategorie($categorie)
            ->setUser($user);
        
            $this->assertFalse ($project->getNom ()=== 'false' );
            $this->assertFalse ( $project->getDateRealisation () === new $datetime);
            $this->assertFalse ( $project->getCreatedAt () === new $datetime);
            $this->assertFalse ($project->getDescription ()=== 'false' );
            $this->assertFalse ($project->getSlug ()=== 'false' );
            $this->assertFalse ($project->getFile ()=== 'false' );
            $this->assertNotContains (new Categorie(), $project->getCategorie());
            $this->assertFalse ($project->getUser ()=== new User());
            
    }

    public function testIsEmpty ()
    {
        $project = new Project();
                
            $this->assertEmpty ($project->getNom());
            $this->assertEmpty ($project->getDateRealisation());
            $this->assertEmpty ($project->getCreatedAt());
            $this->assertEmpty ($project->getDescription());
            $this->assertEmpty ($project->getSlug());
            $this->assertEmpty ($project->getFile());
            $this->assertEmpty ($project->getSlug());
            $this->assertEmpty ($project->getCategorie());
            $this->assertEmpty ($project->getUser());
    }



}
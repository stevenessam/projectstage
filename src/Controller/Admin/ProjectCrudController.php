<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextareaField::new('description'),
            DateField::new('dateRealisation'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
            ImageField::new('file')->setBasePath('/uploads/projects/')->onlyOnIndex(),
            SlugField::new('slug')->setTargetFieldName('nom')->hideOnIndex(),
            AssociationField::new('categorie'),
        ];
    }


    private $security;
    public function __construct (Security $security)
    {
    

        $this->security= $security;
    }


    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(! $entityInstance instanceof Project) return;

            $now = new DateTime('now');
            $entityInstance->setCreatedAt($now);
            
            $user = $this->security->getUser();
            $entityInstance->setUser($user);

            parent::persistEntity($em,$entityInstance);

    }



    public function configureCrud (Crud $crud): Crud
    {
    return$crud
        ->setDefaultSort(['createdAt'=>'DESC'])
        ->setPageTitle ( 'index', 'Projets')
        ->setPageTitle ( 'new', 'Editer les Projets' );
    }
    


    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX,Action::DETAIL);
    }

    
}

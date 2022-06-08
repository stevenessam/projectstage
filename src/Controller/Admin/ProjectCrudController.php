<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
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
            AssociationField::new('categorie')->hideOnIndex(),
            TextareaField::new('description')->setFormType(CKEditorType::class)->hideOnIndex(),
            TextField::new('typeDeProjet'),
            TextField::new('qualiteDuMateriel')->hideOnIndex(),
            TextField::new('dureeDeProjet')->hideOnIndex(),
            DateField::new('dateRealisation'),
            TextField::new('ville'),
            TextField::new('file')->hideOnIndex(),
            TextField::new('file2')->hideOnIndex(),
            SlugField::new('slug')->setTargetFieldName('nom')->hideOnIndex(),
        ];
    }




    // public function configureFields(string $pageName): iterable
    // {

    //     $imageFile1= TextField::new('imageFile')->setFormType(VichImageType::class)->setFormTypeOption('allow_delete', false);
    //     $image1=ImageField::new('file')->setBasePath('/uploads/projects/');
    //     $imageFile2= TextField::new('imageFile2')->setFormType(VichImageType::class)->setFormTypeOption('allow_delete', false);
    //     $image2=ImageField::new('file2')->setBasePath('/uploads/projects/');
    //     $fields=[
    //         TextField::new('nom'),
    //         AssociationField::new('categorie')->hideOnIndex(),
    //         TextareaField::new('description')->hideOnIndex(),
    //         TextField::new('typeDeProjet'),
    //         TextField::new('qualiteDuMateriel')->hideOnIndex(),
    //         TextField::new('dureeDeProjet')->hideOnIndex(),
    //         DateField::new('dateRealisation'),
    //         TextField::new('ville'),
    //         SlugField::new('slug')->setTargetFieldName('nom')->hideOnIndex(),
    //     ];
    //     if($pageName==Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL){
    //          $fields[]=$image1;
    //          $fields[]=$image2;
    //     }else{
    //          $fields[]=$imageFile1;
    //          $fields[]=$imageFile2;
    //     }
    //     return $fields;
    // }




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
        ->setPageTitle ( 'new', 'Editer les Projets' )
        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }
    


    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX,Action::DETAIL);
    }

    
}

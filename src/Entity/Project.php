<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;




#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[Vich\Uploadable] 
/**
 * @Vich\Uploadable
 */
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'datetime')]
    private $dateRealisation;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'string', length: 255)]
    private $file;

    #[ORM\Column(type: 'string', length: 255)]
    private $file2;

    /**
     * @Vich\UploadableField(mapping="project_images", fileNameProperty="file")
     * @var File
     */
    #[Vich\UploadableField(mapping: 'project_images', fileNameProperty: 'file')]
    private $imageFile;



    /**
     * @Vich\UploadableField(mapping="project_images2", fileNameProperty="file2")
     * @var File
     */
    #[Vich\UploadableField(mapping: 'project_images2', fileNameProperty: 'file2')]
    private $imageFile2;




    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'projects')]
    private $categorie;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Commentaire::class)]
    private $commentaires;

    #[ORM\Column(type: 'string', length: 255)]
    private $dureeDeProjet;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeDeProjet;

    #[ORM\Column(type: 'string', length: 255)]
    private $qualiteDuMateriel;

    #[ORM\Column(type: 'string', length: 255)]
    private $ville;

    public function __construct()
    {
        $this->categorie = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateRealisation(): ?\DateTimeInterface
    {
        return $this->dateRealisation;
    }

    public function setDateRealisation(?\DateTimeInterface $dateRealisation): self
    {
        $this->dateRealisation = $dateRealisation;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }


    public function getFile2(): ?string
    {
        return $this->file2;
    }

    public function setFile2(string $file2): self
    {
        $this->file2 = $file2;

        return $this;
    }


    public function setImageFile(File $file = null)
    {
        $this->imageFile = $file;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($file) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->createdAt = new \DateTime('now');
        }
    }


    public function getImageFile()
    {
        return $this->imageFile;
    }



    public function getImageFile2()
    {
        return $this->imageFile2;
    }

    public function setImageFile2(File $file2 = null)
    {
        $this->imageFile2 = $file2;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($file2) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->createdAt = new \DateTime('now');
        }
    }



    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie[] = $categorie;
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        $this->categorie->removeElement($categorie);

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setProject($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getProject() === $this) {
                $commentaire->setProject(null);
            }
        }

        return $this;
    }



    public function __toString()
    {
        return $this->nom;
    }

    public function getDureeDeProjet(): ?string
    {
        return $this->dureeDeProjet;
    }

    public function setDureeDeProjet(string $dureeDeProjet): self
    {
        $this->dureeDeProjet = $dureeDeProjet;

        return $this;
    }

    public function getTypeDeProjet(): ?string
    {
        return $this->typeDeProjet;
    }

    public function setTypeDeProjet(string $typeDeProjet): self
    {
        $this->typeDeProjet = $typeDeProjet;

        return $this;
    }

    public function getQualiteDuMateriel(): ?string
    {
        return $this->qualiteDuMateriel;
    }

    public function setQualiteDuMateriel(string $qualiteDuMateriel): self
    {
        $this->qualiteDuMateriel = $qualiteDuMateriel;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

}

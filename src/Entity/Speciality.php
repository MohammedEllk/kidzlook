<?php

namespace App\Entity;

use App\Repository\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpecialityRepository::class)
 */
class Speciality
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    /**
     * @ORM\ManyToMany(targetEntity=Emploi::class, inversedBy="specialities")
     */
    private $Emploi;

    /**
     * @ORM\ManyToMany(targetEntity=Professeur::class, inversedBy="specialities")
     */
    private $Professeur;

    public function __construct()
    {
        $this->Emploi = new ArrayCollection();
        $this->Professeur = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    /**
     * @return Collection|Emploi[]
     */
    public function getEmploi(): Collection
    {
        return $this->Emploi;
    }

    public function addEmploi(Emploi $emploi): self
    {
        if (!$this->Emploi->contains($emploi)) {
            $this->Emploi[] = $emploi;
        }

        return $this;
    }

    public function removeEmploi(Emploi $emploi): self
    {
        $this->Emploi->removeElement($emploi);

        return $this;
    }

    /**
     * @return Collection|Professeur[]
     */
    public function getProfesseur(): Collection
    {
        return $this->Professeur;
    }

    public function addProfesseur(Professeur $professeur): self
    {
        if (!$this->Professeur->contains($professeur)) {
            $this->Professeur[] = $professeur;
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): self
    {
        $this->Professeur->removeElement($professeur);

        return $this;
    }

  
}

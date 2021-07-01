<?php

namespace App\Entity;

use App\Repository\EmploiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmploiRepository::class)
 */
class Emploi
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
    private $title;

    /**
     * @ORM\Column(type="array")
     */
    private $datetime = [];

    /**
     * @ORM\ManyToMany(targetEntity=Professeur::class, inversedBy="emplois")
     */
    private $Professeur;

    /**
     * @ORM\ManyToMany(targetEntity=Speciality::class, mappedBy="Emploi")
     */
    private $specialities;

    public function __construct()
    {
        $this->Professeur = new ArrayCollection();
        $this->specialities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDatetime(): ?array
    {
        return $this->datetime;
    }

    public function setDatetime(array $datetime): self
    {
        $this->datetime = $datetime;

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

    /**
     * @return Collection|Speciality[]
     */
    public function getSpecialities(): Collection
    {
        return $this->specialities;
    }

    public function addSpeciality(Speciality $speciality): self
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities[] = $speciality;
            $speciality->addEmploi($this);
        }

        return $this;
    }

    public function removeSpeciality(Speciality $speciality): self
    {
        if ($this->specialities->removeElement($speciality)) {
            $speciality->removeEmploi($this);
        }

        return $this;
    }
}

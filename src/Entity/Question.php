<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
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
    private $titles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Reponse;
    /**
     * @ORM\ManyToOne(targetEntity=Jeu::class, inversedBy="Question")
     */
    private $Jeu;
   
    /**
     * @ORM\Column(type="array")
     */
    private $Choix = [];

    /**
     * @ORM\OneToMany(targetEntity=Reponse::class, mappedBy="question")
     */
    private $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitles(): ?string
    {
        return $this->titles;
    }

    public function setTitles(string $titles): self
    {
        $this->titles = $titles;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->Reponse;
    }

    public function setReponse(string $Reponse): self
    {
        $this->Reponse = $Reponse;

        return $this;
    }

    
    public function getChoix(): ?array
    {
        return $this->Choix;
    }

    public function setChoix(array $Choix): self
    {
        $this->Choix = $Choix;

        return $this;
    }
    public function getJeu(): ?Jeu
    {
        return $this->Jeu;
    }

    public function setJeu(?Jeu $Jeu): self
    {
        $this->Jeu = $Jeu;

        return $this;
    }

    /**
     * @return Collection|Reponse[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setQuestion($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestion() === $this) {
                $reponse->setQuestion(null);
            }
        }

        return $this;
    }
}

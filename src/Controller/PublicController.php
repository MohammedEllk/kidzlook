<?php

namespace App\Controller;

use App\Repository\ProfesseurRepository;
use App\Repository\ClasseRepository;
use App\Entity\Professeur;
use App\Entity\Classe;
use App\Form\ProfesseurType;
use App\Entity\Speciality;
use App\Form\SpecialityType;
use App\Repository\CoursRepository;
use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\MatiereRepository;
use App\Entity\Matiere;
use App\Form\MatiereType;
use App\Repository\NiveauRepository;
use App\Entity\Niveau;
use App\Form\NiveauType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Doctrine\ORM\EntityManagerInterface;

class PublicController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }
     /**
     * @Route("/esp_etud",name="esp_etud")
     */
    public function esp_etud()
    {
       
        return $this->render('security/esp_etud.html.twig');
    }
     /**
     * @Route("/esp_prof",name="esp_prof")
     */
    public function esp_prof(ClasseRepository $classe)
    {
        $class = $classe->findAll();
        return $this->render('security/esp_prof.html.twig',[
            'classe' => $class
        ]);
    }
     /**
     * @Route("/show_quest",name="show_quest")
     */
    public function show_quest()
    {
       
        return $this->render('security/question.html.twig');
    }
    /**
     * @Route("/Niveau",name="Niveau")
     */
    public function show_niveau(NiveauRepository $niveau)
    {
        $niveaux = $niveau->findAll();
        return $this->render('security/Niveau.html.twig',[
            'niveau' => $niveaux
        ]);
    }
    /**
     * @Route("/Matiere/{id}",name="Matiere")
     */
    public function show_matiere(NiveauRepository $niveau,Request $request)
    {
        $niveaux = $niveau->find($request->attributes->get("id"));
        $matieres = $niveaux->getMatieres()->toArray();

        return $this->render('security/matiere.html.twig',[
            'matiere' => $matieres
        ]);
    }
    /**
     * @Route("/Cours/{id}",name="Cours")
     */
    public function show_Cours(MatiereRepository $matiere,Request $request)
    { 
        $matieres  = $matiere->find($request->attributes->get("id"));
        $course = $matieres->getCours()->toArray();
        return $this->render('security/cours.html.twig',[
            'cours' => $course
        ]);
    }
    /**
     * @Route("/Courspdf/{id}", name="cours_pdf")
     */
    public function show_cours_pdf(Cours $cours,EntityManagerInterface $em){
        if(!$cours) return $this->redirectToRoute('Cours');
    
        return new BinaryFileResponse('uploads/cours/'.$cours->getPdfName());
    }
}

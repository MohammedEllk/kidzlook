<?php

namespace App\Controller;

use App\Repository\ProfesseurRepository;
use App\Entity\Professeur;
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
use App\Repository\JeuRepository;
use App\Entity\Jeu;
use App\Form\JeuType;
use App\Repository\QuestionRepository;
use App\Entity\Question;
use App\Form\QuestionType;
use App\Entity\Reponse;
use App\Form\ReponseType;
use App\Entity\Classe;
use App\Form\ClasseType;
use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
    /**
     * @Route("admin/Edit_spec/{id}", name="Edit_spec")
     * @Route("admin/Create_spec", name="Create_spec")
     */
    public function createSpec(Speciality $spec=null,Request $request,EntityManagerInterface $em,$_route)
    {
        if($_route=="Edit_spec"){
            if(!$prof)return $this->redirectToRoute('show_prof');
        }
        else{
            $spec = new Speciality;
        }
         
        $form=$this->createForm(SpecialityType::class,$spec);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            
            $em->persist($spec);
            $em->flush();
            return $this->redirectToRoute('show_prof');
        }
        return $this->render('security/create.html.twig',[
            'form'=> $form->createView(),
            'entity' => "créer une spécialité"
        ]);
    }

     /**
     * @Route("admin/Edit_Prof/{id}", name="Edit_Prof")
     * @Route("admin/Create_Prof", name="Create_Prof")
     */
    public function createProf(Professeur $prof=null,Request $request,EntityManagerInterface $em,$_route)
    {
        if($_route=="Edit_Prof"){
            if(!$prof)return $this->redirectToRoute('show_prof');
        }
        else{
            $prof = new Professeur;
        }
        
        $form=$this->createForm(ProfesseurType::class,$prof);
        $form->handleRequest($request);
        $specs = $prof->getSpecialities()->toArray(); 
        
        if($form->isSubmitted() && $form->isValid())
        {
            foreach($specs as $spec)
            {
                if(!$prof->getSpecialities()->contains($spec))
                {
                   $spectoDlt = $em->getRepository(Speciality::class)->find($spec->getId()); 
                   $prof->removeSpeciality();
                    
                }
            }
            foreach($prof->getSpecialities() as $spec)
            {
                    $prof->addSpeciality($spec);
                    $spec->addProfesseur($prof);
                    $em->persist($spec);
            }
            $em->persist($prof);
            $em->flush();
            return $this->redirectToRoute('show_prof');
        }
        return $this->render('security/create.html.twig',[
            'form'=> $form->createView(),
            'entity' => "créer un professeur"
        ]);

    
    }
    /**
     * @Route("admin/Edit_Etud/{id}", name="Edit_Etud")
     * @Route("admin/Create_Etud", name="Create_Etud")
     */
    public function createEtud(Etudiant $etud=null,Request $request,EntityManagerInterface $em,$_route)
    {
        if($_route=="Edit_Etud"){
            if(!$etud)return $this->redirectToRoute('show_prof');
        }
        else{
            $etud = new Etudiant;
        }
        
        $form=$this->createForm(EtudiantType::class,$etud);
        $form->handleRequest($request);
        
        
        if($form->isSubmitted() && $form->isValid())
        {
            
            $em->persist($etud);
            $em->flush();
            return $this->redirectToRoute('show_prof');
        }
        return $this->render('security/create.html.twig',[
            'form'=> $form->createView(),
            'entity' => "créer un étudiant"
        ]);

    
    }
    /**
     * @Route("admin/Edit_Classe/{id}", name="Edit_Classe")
     * @Route("admin/Create_Classe", name="Create_Classe")
     */
    public function createClasse(Etudiant $classe=null,Request $request,EntityManagerInterface $em,$_route)
    {
        if($_route=="Edit_Classe"){
            if(!$classe)return $this->redirectToRoute('show_prof');
        }
        else{
            $classe = new Classe;
        }
        
        $form=$this->createForm(ClasseType::class,$classe);
        $form->handleRequest($request);
        $profs = $classe->getProfesseur()->toArray();
        $etuds = $classe->getEtudiant()->toArray();
        
        if($form->isSubmitted() && $form->isValid())
        {
            foreach($profs as $prof)
            {
                if(!$classe->getProfesseur()->contains($prof))
                {
                    $ProftoDlt = $em->getRepository(Professeur::class)->find($prof->getId());
                    $prof->removeClasse($ProftoDlt);
                    
                }
            }
            foreach($classe->getProfesseur() as $prof)
            {
                    $classe->addProfesseur($prof);
                    $prof->addClass($classe);
                    $em->persist($prof);
            }
            foreach($etuds as $etud)
            {
                if(!$classe->getEtudiant()->contains($etud))
                {
                    $EtudtoDlt = $em->getRepository(Etudiant::class)->find($etud->getId());
                    $etud->removeClasse($EtudtoDlt);
                    
                }
            }
            foreach($classe->getEtudiant() as $etud)
            {
                    $classe->addEtudiant($etud);
                    $etud->setClasse($classe);
                    $em->persist($etud);
            }
            
            $em->persist($classe);
            $em->flush();
            return $this->redirectToRoute('show_prof');
        }
        return $this->render('security/create.html.twig',[
            'form'=> $form->createView(),
            'entity' => "créer une Classe"
        ]);

    
    }
     /**
     * @Route("admin/esp_admin",name="esp_admin")
     */
    public function esp_prof()
    {
       
        return $this->render('security/esp_admin.html.twig');
    }
    /**
     * @Route("admin/show_prof",name="show_prof")
     */
    public function showprof(ProfesseurRepository $prof)
    {
       $profs =  $prof->findAll();
        return $this->render('security/show_prof.html.twig',[
            'prof' => $profs
        ]);
    }
    /**
     * @Route("admin/show_jeu",name="show_jeu")
     */
    public function showJeu(JeuRepository $jeu)
    {
       $jeux =  $jeu->findAll();
        return $this->render('security/show_jeu.html.twig',[
            'jeu' => $jeux
        ]);
    }
    /**
     * @Route("admin/show_cours",name="show_cours")
     */
    public function showcours(CoursRepository $cours,NiveauRepository $niveau)
    {
       $niveaux =  $niveau->findAll();
       $course =  $cours->findAll();
        return $this->render('security/show_cours.html.twig',[
            'cours' => $course,
            'niveau' => $niveaux
        ]);
    }
    /**
     * @Route("admin/Edit_Niveau/{id}", name="Edit_Niveau")
     * @Route("admin/Create_Niveau", name="Create_Niveau")
     */
    public function createNiv(Niveau $niv=null,Request $request,EntityManagerInterface $em,$_route)
    {
        if($_route=="Edit_Niveau"){
            if(!$niv)return $this->redirectToRoute('show_cours');
        }
        else{
            $niv = new Niveau;
        }
         
        $form=$this->createForm(NiveauType::class,$niv);
        $form->handleRequest($request);
        $mat = $niv->getMatieres()->toArray(); 
        
        if($form->isSubmitted() && $form->isValid())
        {
            foreach($mat as $mati)
            {
                if(!$niv->getMatieres()->contains($mati))
                {
                    $nivtoDlt = $em->getRepository(Matiere::class)->find($mati->getId());
                    $niv->removeMatiere($nivtoDlt);
                    
                }
            }
            foreach($niv->getMatieres() as $mati)
            {
                    $niv->addMatiere($mati);
                    $mati->setNiveau($niv);
                    $em->persist($mati);
            }
            
            $em->persist($niv);
            $em->flush();
            return $this->redirectToRoute('show_cours');
        }
        return $this->render('security/create.html.twig',[
            'form'=> $form->createView(),
            'entity' => "créer un niveau"
        ]);
    }
    /**
     * @Route("admin/Edit_Mat/{id}", name="Edit_Mat")
     * @Route("admin/Create_Mat", name="Create_Mat")
     */
    public function createMat(Matiere $mat=null,Request $request,EntityManagerInterface $em,$_route)
    {
        if($_route=="Edit_Mat"){
            if(!$mat)return $this->redirectToRoute('show_cours');
        }
        else{
            $mat = new Matiere;
        }
         
        $form=$this->createForm(MatiereType::class,$mat);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            
            $em->persist($mat);
            $em->flush();
            return $this->redirectToRoute('show_cours');
        }
        return $this->render('security/create.html.twig',[
            'form'=> $form->createView(),
            'entity' => "créer une matiere"
        ]);
    }
     /**
     * @Route("admin/Edit_cours/{id}", name="Edit_cours")
     * @Route("admin/Create_cours", name="Create_cours")
     */
    public function create_Cours(Cours $cours=null,Request $request,EntityManagerInterface $em,$_route)
    {
        if($_route=="Edit_cours"){
            if(!$cours)return $this->redirectToRoute('show_cours');
        }
        else{
            $cours = new Cours;
        }
        
        $form=$this->createForm(CoursType::class,$cours);
        $form->handleRequest($request);
        
        
        if($form->isSubmitted() && $form->isValid())
        {
            
            
            $em->persist($cours);
            $em->flush();

            return $this->redirectToRoute('show_cours');
        }
        return $this->render('security/create.html.twig',[
            'form'=> $form->createView(),
            'entity' => "créer un cours"
        ]);

    
    }
    /**
     * @Route("admin/Edit_Question/{id}", name="Edit_Question")
     * @Route("admin/Create_Question", name="Create_Question")
     */
    public function create_Question(Question $question=null,Request $request,EntityManagerInterface $em,$_route)
    {
        if($_route=="Edit_Question"){
            if(!$question)return $this->redirectToRoute('show_jeu');
        }
        else{
            $question = new Question;
        }
        
        $form=$this->createForm(QuestionType::class,$question);
        $form->handleRequest($request);
        $arrayReponse = array();
        
        $reponse = $question->getReponses();
        if($form->isSubmitted() && $form->isValid())
        {
            
            foreach($reponse as $rep)
            {
                if(!$question->getReponses()->contains($rep))
                {
                    
                $reponsetoDlt = $em->getRepository(Reponse::class)->find($rep->getId());
                     
                $question->removeReponse($reponsetoDlt);
                
                } 
                
            }
            foreach($question->getReponses() as $rep)
            {
                $em->persist($rep);
                
            }
            foreach($question->getReponses() as $rep)
            {
                array_push($arrayReponse,$rep->getReponse());
            }
            
            $question->setChoix($arrayReponse);
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('show_jeu');
        }
        return $this->render('security/addQuestion.html.twig',[
            'form'=> $form->createView(),
            'entity' => "créer une question"
        ]);

    
    }
    /**
     * @Route("admin/Edit_Jeu/{id}", name="Edit_Jeu")
     * @Route("admin/Create_Jeu", name="Create_Jeu")
     */
    public function create_jeu(Jeu $jeu=null,Request $request,EntityManagerInterface $em,$_route)
    {
        if($_route=="Edit_Jeu"){
            if(!$question)return $this->redirectToRoute('show_jeu');
        }
        else{
            $jeu = new Jeu;
        }
        
        $form=$this->createForm(JeuType::class,$jeu);
        $form->handleRequest($request);
        
        $question = $jeu->getQuestion()->toArray(); 
        if($form->isSubmitted() && $form->isValid())
        {
            foreach($question as $quest)
            {   
                if(!$jeu->getQuestion()->contains($quest))
                {
                    
                $questtoDlt = $em->getRepository(Question::class)->find($quest->getId());
                     
                $jeu->removeQuestion($questtoDlt);
                
                }
            }
            foreach($jeu->getQuestion() as $quest)
            {
                    $jeu->addQuestion($quest);
                    $quest->setJeu($jeu);
                    $em->persist($quest);
            }

            
            $em->persist($jeu);
            $em->flush();

            return $this->redirectToRoute('show_jeu');
        }
        return $this->render('security/create.html.twig',[
            'form'=> $form->createView(),
            'entity' => "créer une jeu"
        ]);

    
    }
    /**
     * @Route("admin/Delete_Niveau/{id}", name="Delete_Niveau")
     */
    public function Delete_Niveau(Niveau $niveau,EntityManagerInterface $em)
    {
           $matiere = $niveau->getMatieres()->toArray();
           foreach($mat as $matiere)
           {
               $cours = $mat->getCours()->toArray();
               foreach($course as $cours)
               {
                 $em->remove($course);
                 $em->persist;
               }
               $em->remove($mat);
           }
           $em->remove($niveau);
           $em->flush();
           return $this->redirectToRoute('show_cours');
    }
    /**
     * @Route("admin/Delete_matieres/{id}", name="Delete_matieres")
     */
    public function Delete_Matiere(Matiere $matiere,EntityManagerInterface $em)
    {
           $cours = $matiere->getCours()->toArray();
           foreach($course as $cours)
           {
               $em->remove($course);
               $em->persist();
           }
           $em->remove($matiere);
           $em->flush();
           return $this->redirectToRoute('show_cours');
    }
    /**
     * @Route("admin/Delete_cours/{id}", name="Delete_cours")
     */
    public function Delete_cours(Cours $cours,EntityManagerInterface $em)
    {
           
           $em->remove($cours);
           $em->flush();
           return $this->redirectToRoute('show_cours');
    }
    /**
     * @Route("admin/Delete_Question/{id}", name="Delete_Question")
     */
    public function Delete_Question(Question $question,EntityManagerInterface $em)
    {
           
           $em->remove($question);
           $em->flush();
           return $this->redirectToRoute('show_cours');
    }
    /**
     * @Route("admin/Delete_Jeu/{id}", name="Delete_jeu")
     */
    public function Delete_Jeu(Jeu $jeu,EntityManagerInterface $em)
    {
           $questions = $jeu->getQuestion()->toArray();
           foreach($questions as $ques)
           {
            $em->remove($ques);
           }
           
           $em->remove($jeu);
           $em->flush();
           return $this->redirectToRoute('show_cours');
    }
    /**
     * @Route("/api/question", name="question")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getQuestion(QuestionRepository $question,SerializerInterface $serializer)

    {
        
        $allquestion= $question->findAll();

        $response = new Response();

        // Tip : Inject SerializerInterface $serializer in the controller method
        // and avoid these 3 lines of instanciation/configuration
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $data = $serializer->serialize($allquestion, 'json', [
            'circular_reference_handler' => function ($allquestion) {
                return $allquestion->getId();
            }
        ]);
        $response = new Response($data);  
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


}

<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Professeur;
use App\Form\ProfesseurType;
use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\TypeEntityType;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('Professeur', EntityType::class, [
                'required' => false,
                'class' => Professeur::class,
                'choice_label' => "nom",
                'multiple'  => true,
                'label' => 'Professeurs',
            ])
            ->add('Etudiant', EntityType::class, [
                'required' => false,
                'class' => Etudiant::class,
                'choice_label' => "nom",
                'multiple'  => true,
                'label' => 'Etudiants',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Classe::class,
        ]);
    }
}

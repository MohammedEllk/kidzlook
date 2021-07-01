<?php

namespace App\Form;

use App\Entity\Professeur;
use App\Entity\Speciality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\TypeEntityType;

class ProfesseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom',TextType::class)
            ->add('nom',TextType::class)
            ->add('age')
            ->add('Description',TextType::class)
            ->add('specialities', EntityType::class, [
                'required' => false,
                'class' => Speciality::class,
                'choice_label' => "title",
                'multiple'  => true,
                'label' => 'specialities',
            ]);

        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Professeur::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Niveau;
use App\Entity\Matiere;
use App\Form\MatiereType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\TypeEntityType;

class NiveauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('matieres', EntityType::class, [
                'required' => false,
                'class' => Matiere::class,
                'choice_label' => "title",
                'multiple'  => true,
                'label' => 'matieres',
            ]);
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Niveau::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Cours;
use App\Form\MatiereType;
use App\Entity\Matiere;
use App\Entity\Niveau;
use App\Form\NiveauType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\TypeEntityType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('pdfFile', VichFileType::class, [
                'label' => 'pdf (pdf file)',
                'allow_delete' => true,
                'delete_label' => '...',
                'download_uri' => '...',
                'download_label' => '...',
                'asset_helper' => true,
            ])
            ->add('matiere', EntityType::class, [
                'required' => false,
                'class' => Matiere::class,
                'choice_label' => "title",
                'multiple'  => false,
                'label' => 'matieres',
            ])
            ->add('Niveau', EntityType::class, [
                'required' => false,
                'class' => Niveau::class,
                'choice_label' => "title",
                'multiple'  => false,
                'label' => 'Niveau',
            ]);
            
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}

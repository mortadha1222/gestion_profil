<?php

namespace App\Form;

use App\Entity\Actualities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ActualitiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleAct')
            ->add('dateAct',DateType::class)
            ->add('descriptionAct')
            
            ->add('photoAct',FileType::class, [
                'label' => 'Please upload your image' ,
            'mapped' => false,        ])
            ->add('idMember')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actualities::class,
        ]);
    }
}
